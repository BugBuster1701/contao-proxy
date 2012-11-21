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
 * Class Proxy
 *
 * Provide methods to handle HTTP Proxy informations.
 * @copyright  Jörg Kleuver 2008, TYPOlight Version
 * @author     Jörg Kleuver <joerg@kleuver.de>
 *
 * @copyright  Glen Langer 2012
 * @author     Glen Langer (BugBuster); for Contao 3
 * @version    3.0.0
 * @package    Proxy
 * @license    LGPL
*/
class Proxy
{

	/**
	 * Proxy settings
	 * @var array
	 */
	protected $arrProxy = array(
							'proxy_host'    => '',
							'proxy_port'    => 8080,
							'proxy_user'    => '',
							'proxy_pass'    => ''
							);

	/**
	 * Local settings
	 * @var array
	 */
	protected $arrLocal = array();

	/**
	 * Set default values
	 * @param string	$strUrl
	 * @param string	$strLocal
	 * @throws Exception
	 */
	public function __construct($strUrl = '', $strLocal = '')
	{
		$this->setProxy($strUrl);
		$this->setLocal($strLocal);
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
			case 'proxy':
				$this->setProxy($varValue);
				break;

			case 'local':
				$this->setLocal($varValue);
				break;

			case 'host':
			case 'port':
			case 'user':
			case 'pass':
				$this->arrProxy['proxy_'.$strKey] = $varValue;
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
			case 'host':
			case 'port':
			case 'user':
			case 'pass':
				return $this->arrProxy['proxy_'.$strKey];
				break;

			default:
				throw new Exception(sprintf('Unknown or protected property "%s"', $strKey));
				break;
		}
	}

	/**
	 * Return true if strHost is Local
	 * @param string
	 * @return bool
	 */
	public function isLocal($strHost)
	{
		if ($this->arrLocal)
		{
			// check if $strHost matches $local
			foreach ($this->arrLocal as $local)
			{
				// check if strings match
				if ($strHost == $local) return true;

				switch ($this->hostType($strHost))
				{
					case 'host-name':
						switch ($this->hostType($local))
						{
							case 'host-name':
								// should never reach this, already checked
								if ($strHost == $local) return true;
								break;

							case 'domain-name':
								if ($this->inDomain($strHost, $local)) return true;
								break;

//							// Question: Do we rally want to check a host name against ip-adress or ip-range ?
//							case 'ip-address':
//					 			// do reverse lookup of $strHost and then check if ip-addresses match $local
//								// Don't do a reverse lookup of an ip-address !
//								foreach (gethostbynamel($strHost) as $ip)
//								{
//									if ($ip == $local) return true;
//								}
//								break;
//
//							case 'ip-range':
//					 			// do reverse lookup of $strHost and then check if addresses is in ip-range of $local
//								foreach (gethostbynamel($strHost) as $ip)
//								{
//									if ($this->inRange($ip, $local)) return true;
//								}
//								break;

							default:
								break;
						}
						break;

					case 'ip-address':
						switch ($this->hostType($local))
						{
//							// Question: Do we rally want to check an ip-address against a host name ?
//							case 'host-name':
//					 			// do reverse lookup of $local and then check if addresses match $strHost
//								// Don't do a reverse lookup of an ip-address !
//								foreach (gethostbynamel($local) as $ip)
//								{
//									if ($ip == $strHost) return true;
//								}
//								break;

							case 'ip-address':
								// should never reach this, already checked
								if ($strHost == $local) return true;
								break;

							case 'ip-range':
								if ($this->inRange($strHost, $local)) return true;
								break;

							default:
								break;
						}
						break;
				}
			}
		}

		return false;
	}
	
	/**
	 * Set Proxy and return true if set
	 * @param string
	 * @return bool
	 * @throws Exception
	 */
	private function setProxy($strUrl = '')
	{
		// set arrProxy
		if ($strUrl)
		{
			$proxy_uri = parse_url($strUrl);
			if (! $proxy_uri) 
			{
				throw new Exception(sprintf($GLOBALS['TL_LANG']['tl_proxy']['error_url'], $strUrl));
			}

			if ($proxy_uri['scheme'] != 'http')
			{
				throw new Exception(sprintf($GLOBALS['TL_LANG']['tl_proxy']['error_scheme'], $proxy_uri['scheme']));
				return false;
			}

			$this->arrProxy = array(
								'proxy_host'  => $proxy_uri['host'],
								'proxy_port'  => $proxy_uri['port'],
								'proxy_user'  => $proxy_uri['user'],
								'proxy_pass'  => $proxy_uri['pass']
								);

			return true;
		}

		return false;
	}

	/**
	 * Set Local and return true if set
	 * @param string
	 * @return bool
	 * @throws Exception
	 */
	private function setLocal($strLocal = '')
	{
		// set arrLocal
		if ($strLocal)
		{
			$arrLocal = explode(",", $strLocal);
			foreach ($arrLocal as $key => $value)
			{
				$arrLocal[$key] = strtolower(trim($value));
				if (! $this->hostType($arrLocal[$key]))
				{
					throw new Exception(sprintf($GLOBALS['TL_LANG']['tl_proxy']['error_local'], $arrLocal[$key]));
				}
			}

			$this->arrLocal = $arrLocal;
			return true;
		}

		return false;
	}

	/**
	 * Return type of Host
	 * @param string
	 * @return mixed
	 */
	private function hostType($strHost)
	{
		// sanity check of $strHost
	    if(preg_match("/[^a-z0-9\.\-]/i", $strHost)) return false;

		$strSlices = explode('.', $strHost);

		// check for domain or ip range
		if ($strHost[0] == '.')
		{
			if(count($strSlices) < 2) return false;

			$TLD = array_pop($strSlices); // TLD is last
			$ccTLD = array_pop($strSlices); // ccTLD is 2nd last
			if((strlen($TLD) < 2) || (strlen($ccTLD) < 2)) return false;

			return 'domain-name';
		} 
		else if (substr($strHost, -1) == '.')
		{
			if(count($strSlices) < 1) return false;
			if(preg_match("/[^0-9\.]/i", $strHost)) return false;
			return 'ip-range';
		}

		// check for missing '.' at beginning of domains
		if(count($strSlices) == 2) return false;

		// check for missing '.' at end of ip range
		if(count($strSlices) < 4 && ! preg_match("/[^0-9\.]/i", $strHost)) return false;

		// if it's not an ip address, it's an host name
		if ((ip2long($strHost)) === false)
		{
			return 'host-name';
		} 
		else
		{
			return 'ip-address';
		}

		// we should never reach this
		return false;
	}

	/**
	 * @param string
	 * Check if IP Address is in IP Range
	 * @param string
	 * @return bool
	 */
	private function inRange($strIp, $strRange)
	{
		if (preg_match("/^{$strRange}/", $strIp)) return true;
		return false;
	}

	/**
	 * Check if Host is in Domain
	 * @param string
	 * @param string
	 * @return bool
	 */
	private function inDomain($strHost, $strDomain)
	{
		if (preg_match("/{$strDomain}$/", $strHost)) return true;
		return false;
	}
}
