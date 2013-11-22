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
 * Add to palette
 */
$GLOBALS['TL_DCA']['tl_settings']['palettes']['__selector__'][] = 'useProxy';
$GLOBALS['TL_DCA']['tl_settings']['palettes']['default'] .= ';{proxy_out_legend:hide},useProxy;';

/**
 * Add to subpalette
 */
$GLOBALS['TL_DCA']['tl_settings']['subpalettes']['useProxy'] = 'proxy_url,proxy_local';


/**
 * Add fields
 */
$GLOBALS['TL_DCA']['tl_settings']['fields']['useProxy'] = array
(
	'label'         => &$GLOBALS['TL_LANG']['tl_settings']['useProxy'],
	'inputType'     => 'checkbox',
	'eval'          => array('submitOnChange'=>true)
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['proxy_url'] = array
(
	'label'         => &$GLOBALS['TL_LANG']['tl_settings']['proxy_url'],
	'default'       => '',
	'exclude'       => true,
	'inputType'     => 'text',
	'save_callback' => array( array('tl_proxy', 'checkProxyUrl') ),
	'eval'          => array('mandatory'=>true, 'maxlength'=>255, 'nospace'=>true, 'rgxp'=>'url')
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['proxy_local'] = array
(
	'label'         => &$GLOBALS['TL_LANG']['tl_settings']['proxy_local'],
	'default'       => '',
	'exclude'       => true,
	'inputType'     => 'text',
	'save_callback' => array( array('tl_proxy', 'checkProxyLocal') ),
	'eval'          => array('maxlength'=>255)
);

/**
 * Class tl_proxy
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  Jörg Kleuver 2008
 * @author     Jörg Kleuver <joerg@kleuver.de>
 * @copyright  Glen Langer 2012..2013
 * @author     Glen Langer (BugBuster); for Contao 3
 */
class tl_proxy extends Backend
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
				@$this->resProxy = new Proxy($varValue);
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
				@$this->resProxy = new Proxy('', $varValue);
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
