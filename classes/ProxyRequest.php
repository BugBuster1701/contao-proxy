<?php 

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2012 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 * 
 * Proxy Module
 * 
 * PHP version 5
 * @copyright  Jörg Kleuver 2008, TYPOlight Version
 * @author     Jörg Kleuver <joerg@kleuver.de>
 *
 * @copyright  Glen Langer 2012
 * @author     Glen Langer (BugBuster); for Contao 3
 * @package    Proxy 
 * @license    LGPL 
 */

/**
 * Class ProxyRequest
 *
 * Provide methods to handle HTTP request over Proxy.
 * Enhance Request class from Leo Feyer with proxy functionality.
 * @author     Jörg Kleuver
 *
 * @copyright  Glen Langer 2012
 * @author     Glen Langer (BugBuster); for Contao 3
 * @version    3.0.0
 * @package    Proxy
 * @license    LGPL
 */
class ProxyRequest
{

	/**
	 * Data to be added to the request
	 * @var string
	 */
	protected $strData;

	/**
	 * Request method (defaults to GET)
	 * @var string
	 */
	protected $strMethod;

	/**
	 * Error string
	 * @var string
	 */
	protected $strError;

	/**
	 * Response code
	 * @var integer
	 */
	protected $intCode;

	/**
	 * Response string
	 * @var string
	 */
	protected $strResponse;

	/**
	 * Request string
	 * @var string
	 */
	protected $strRequest;

	/**
	 * Headers array (these headers will be sent)
	 * @var array
	 */
	protected $arrHeaders = array();

	/**
	 * Response headers array (these headers are returned)
	 * @var array
	 */
	protected $arrResponseHeaders = array();

	/**
	 * Proxy handle
	 * @var resource
	 */
	protected $resProxy;

    /**
	 * The socket for server connection
	 * @var resource | null
	 */
    protected $socket = null;
	
	/**
	 * Set default values
	 * @throws Exception
	 */
	public function __construct()
	{
		$this->strData = '';
		$this->strMethod = 'GET';

		// check proxy settings
		if ($GLOBALS['TL_CONFIG']['useProxy'])
		{
			$this->resProxy = new Proxy($GLOBALS['TL_CONFIG']['proxy_url'], $GLOBALS['TL_CONFIG']['proxy_local']);
		}
	}


	/**
	 * Set an object property
	 * @param string
	 * @param mixed
	 * @throws Exception
	 */
	public function __set($strKey, $varValue)
	{
		switch ($strKey)
		{
			case 'data':
				$this->strData = $varValue;
				break;

			case 'method':
				$this->strMethod = $varValue;
				break;

			case 'proxy':
				if (is_resource($varValue))
				{
					$this->resProxy = $varValue;
				}
				break;

			default:
				throw new Exception(sprintf('Invalid argument "%s"', $strKey));
				break;
		}
	}


	/**
	 * Return an object property
	 * @param string
	 * @return mixed
	 * @throws Exception
	 */
	public function __get($strKey)
	{
		switch ($strKey)
		{
			case 'error':
				return $this->strError;
				break;

			case 'code':
				return $this->intCode;
				break;

			case 'request':
				return $this->strRequest;
				break;

			case 'response':
				return $this->strResponse;
				break;

			case 'headers':
				return $this->arrResponseHeaders;
				break;

			case 'proxy':
				return $this->resProxy;
				break;

			default:
				throw new Exception(sprintf('Unknown or protected property "%s"', $strKey));
				break;
		}
	}


	/**
	 * Set additional request headers
	 * @param string
	 * @param mixed
	 */
	public function setHeader($strKey, $varValue)
	{
		$this->arrHeaders[$strKey] = $varValue;
	}


	/**
	 * Return true if there has been an error
	 * @return boolean
	 */
	public function hasError()
	{
		return strlen($this->strError) ? true : false;
	}


	/**
	 * Perform an HTTP request (handle GET, POST, PUT and any other HTTP request)
	 * @param string
	 * @param string
	 * @param string
	 */
	public function send($strUrl, $strData=false, $strMethod=false)
	{
		$default = array
		(
		);

		if ($strData)
		{
			$this->strData = $strData;
			$default['Content-Length'] = 'Content-Length: '. strlen($this->strData);
		}

		if ($strMethod)
		{
			$this->strMethod = strtoupper($strMethod);
		}

		$uri = parse_url($strUrl);
		switch ($uri['scheme'])
		{
			case 'http':
				$port = isset($uri['port']) ? $uri['port'] : 80;
				$host = $uri['host'] . (($port != 80) ? ':' . $port : '');
				$secure = false;
				break;

			case 'https':
				$port = isset($uri['port']) ? $uri['port'] : 443;
				$host = $uri['host'] . (($port != 443) ? ':' . $port : '');
				$secure = true;
				break;

			default:
				$this->strError = 'Invalid schema ' . $uri['scheme'];
				return;
				break;
		}

    	// Add the user-agent header
		if (! isset($this->arrHeaders['User-Agent']))
		{
			$this->arrHeaders['User-Agent'] = 'Contao (+http://contao.org/)';
    	}

		// Connect to host through proxy or direct
		if ($this->resProxy && ! $this->resProxy->isLocal($uri['host']))
		{
			$this->connect($this->resProxy->host, $this->resProxy->port, false);
			if (! is_resource($this->socket))
			{
				// unable to connect to proxy server
				return;
			}

			// Add Proxy-Authorization header
			if ($this->resProxy->user && ! isset($this->arrHeaders['Proxy-Authorization']))
			{
				$this->arrHeaders['Proxy-Authorization'] = 'Basic '.base64_encode ($this->resProxy->user . ':' . $this->resProxy->pass);
			}

			// if we are proxying HTTPS, preform CONNECT handshake with the proxy
			if ($uri['scheme'] == 'https') {
				try 
				{
					@$this->connectHandshake($host, $port);
				}
				catch (Exception $e)
				{
					// Close socket
					@fclose($this->socket);
					$this->strError = $e->getMessage();
				}
			}
		} 
		else
		{
			$this->connect($host, $port, $secure);
		}

		if (! is_resource($this->socket))
		{
			// unable to connect to host
			return;
		}

		// Build request headers	
		if ($this->resProxy && $uri['scheme'] != 'https')
		{
			$request = "{$this->strMethod} {$strUrl} HTTP/1.0\r\n";
		} else
		{
			$path = isset($uri['path']) ? $uri['path'] : '/';
			if (isset($uri['query']))
			{
				$path .= '?' . $uri['query'];
			}

			$request = "{$this->strMethod} {$path} HTTP/1.0\r\n";
			$request .= "Host: {$host} \r\n";
		}

		// Add all headers to the request string
		foreach ($this->arrHeaders as $header=>$value)
		{
			$default[$header] = $header . ': ' . $value;
		}
		$request .= implode("\r\n", $default);

        // Add the request body
		$request .= "\r\n\r\n";
		if (strlen($this->strData))
		{
			$request .= $this->strData . "\r\n";
		}

		$this->strRequest = $request;
		fwrite($this->socket, $request);

		$response = '';
		while (!feof($this->socket) && ($chunk = fread($this->socket, 1024)) != false)
		{
			$response .= $chunk;
		}

		@fclose($this->socket);

		list($split, $this->strResponse) = explode("\r\n\r\n", $response, 2);
		$split = preg_split("/\r\n|\n|\r/", $split);

		$this->arrResponseHeaders = array();
		list($protocol, $code, $text) = explode(' ', trim(array_shift($split)), 3);

		while (($line = trim(array_shift($split))) != false)
		{
			list($header, $value) = explode(':', $line, 2);

			if (isset($this->arrResponseHeaders[$header]) && $header == 'Set-Cookie')
			{
				$this->arrResponseHeaders[$header] .= ',' . trim($value);
			}
			else
			{
				$this->arrResponseHeaders[$header] = trim($value);
			}
		}

		$responses = array
		(
			100 => 'Continue',
			101 => 'Switching Protocols',
			200 => 'OK',
			201 => 'Created',
			202 => 'Accepted',
			203 => 'Non-Authoritative Information',
			204 => 'No Content',
			205 => 'Reset Content',
			206 => 'Partial Content',
			300 => 'Multiple Choices',
			301 => 'Moved Permanently',
			302 => 'Found',
			303 => 'See Other',
			304 => 'Not Modified',
			305 => 'Use Proxy',
			307 => 'Temporary Redirect',
			400 => 'Bad Request',
			401 => 'Unauthorized',
			402 => 'Payment Required',
			403 => 'Forbidden',
			404 => 'Not Found',
			405 => 'Method Not Allowed',
			406 => 'Not Acceptable',
			407 => 'Proxy Authentication Required',
			408 => 'Request Time-out',
			409 => 'Conflict',
			410 => 'Gone',
			411 => 'Length Required',
			412 => 'Precondition Failed',
			413 => 'Request Entity Too Large',
			414 => 'Request-URI Too Large',
			415 => 'Unsupported Media Type',
			416 => 'Requested range not satisfiable',
			417 => 'Expectation Failed',
			500 => 'Internal Server Error',
			501 => 'Not Implemented',
			502 => 'Bad Gateway',
			503 => 'Service Unavailable',
			504 => 'Gateway Time-out',
			505 => 'HTTP Version not supported'
		);

		if (!isset($responses[$code]))
		{
			$code = floor($code / 100) * 100;
		}

		$this->intCode = $code;

		if (!in_array(intval($code), array(200, 304)))
		{
			$this->strError = strlen($text) ? $text : $responses[$code];
		}
	}

	/**
	 * Connect to the remote server or proxy
	 * @param string
	 * @param int
	 * @param boolean
	 */
	private function connect($host, $port = 80, $secure = false)
	{
		if ($secure)
		{
			$this->socket = @fsockopen('ssl://'.$host, $port, $errno, $errstr, 20);
		} 
		else
		{
			$this->socket = @fsockopen($host, $port, $errno, $errstr, 15);
		}

		if (! is_resource($this->socket))
		{
			$this->strError = trim($errno .' '. $errstr);
		}
	}

	/**
	 * Preform HTTPS handshaking with  proxy using CONNECT method
	 * @param string  $host
	 * @param integer $port
	 * @throws Exception
	 */
	private function connectHandshake($host, $port = 443)
	{
		$request = "CONNECT $host:$port HTTP/1.0\r\n" . "Host: " . $this->resProxy->host . "\r\n";

    	// Add the user-agent header
		if (isset($this->arrHeaders['User-Agent']))
		{
			$request .= "User-Agent: " . $this->arrHeaders['User-Agent'] . "\r\n";
    	}
    	
		// If the proxy-authorization header is set, send it to proxy but remove it from headers sent to target host
		if (isset($this->arrHeaders['Proxy-Authorization'])) 
		{
    	    $request .= "Proxy-Authorization: " . $this->arrHeaders['Proxy-Authorization'] . "\r\n";
    	    unset($this->arrHeaders['Proxy-Authorization']);
    	}
		$request .= "\r\n";

		// Send the request
		if (! @fwrite($this->socket, $request))
		{
			throw new Exception("Error writing request to proxy server");
		}

        // Read response headers only
        $response = '';
        $gotStatus = false;
        while ($line = @fgets($this->socket))
		{
			$gotStatus = $gotStatus || (strpos($line, 'HTTP') !== false);
			if ($gotStatus) 
			{
				$response .= $line;
				if (!chop($line)) break;
			}
		}

		// Check that the response from the proxy is 200
		if (substr($response, 9, 3) != 200) 
		{
			throw new Exception("Unable to connect to HTTPS proxy. Server response: " . $response);
		}

		// If all is good, switch socket to secure mode. We have to fall back
		// through the different modes 
		$modes = array(
					STREAM_CRYPTO_METHOD_TLS_CLIENT, 
					STREAM_CRYPTO_METHOD_SSLv3_CLIENT,
					STREAM_CRYPTO_METHOD_SSLv23_CLIENT,
					STREAM_CRYPTO_METHOD_SSLv2_CLIENT 
					);

		$success = false; 
		foreach($modes as $mode)
		{
			$success = stream_socket_enable_crypto($this->socket, true, $mode);
			if ($success) break;
		}

		if (! $success)
		{
			throw new Exception("Unable to connect to HTTPS server through proxy: could not negotiate secure connection.");
		}
	}

}
	