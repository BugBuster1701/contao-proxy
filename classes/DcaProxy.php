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
 * @copyright  Glen Langer 2012..2013
 * @author     Glen Langer (BugBuster); for Contao 3
 * @package    Proxy 
 * @license    LGPL 
 */

/**
 * Class DcaProxy
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  Glen Langer 2012..2013
 * @author     Glen Langer (BugBuster)
 */
class DcaProxy extends Backend
{

	/**
	 * Proxy handle
	 * @var resource
	 */
	protected $resProxy;

	/**
	 * checkProxyUrl
	 * @param mixed
	 * @return string
	 */
	public function checkProxyUrl($varValue)
	{
		if (strlen($varValue))
		{
			try 
			{
				$this->resProxy = new Proxy($varValue);
			}
			catch (Exception $e)
			{
				throw new Exception($e->getMessage());
			}
			return $varValue;
		}
		return '';
	}

	/**
	 * checkProxyLocal
	 * @param mixed
	 * @return string
	 */
	public function checkProxyLocal($varValue)
	{
		if (strlen($varValue))
		{
			try 
			{
				$this->resProxy = new Proxy('', $varValue);
			}
			catch (Exception $e)
			{
				throw new Exception($e->getMessage());
			}
			return $varValue;
		}
		return '';
	}

}
