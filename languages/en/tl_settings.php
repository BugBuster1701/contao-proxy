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
 * Fields
 */
$GLOBALS['TL_LANG']['tl_settings']['proxy_legend'] = "Proxy configuration";
$GLOBALS['TL_LANG']['tl_settings']['useProxy']     = array('Use Proxy to access the Internet', 'If no direct connetion to the internet is possible, you can define a proxy.');
$GLOBALS['TL_LANG']['tl_settings']['proxy_url']    = array('URL of Proxy Server', 'Example: "http://[user:passwort@]host[:port]" ...');
$GLOBALS['TL_LANG']['tl_settings']['proxy_local']  = array('No Proxy for', 'Example: "localhost, 127.0.0.1, .example.com, 192.168." ...');

/**
 * Error messages
 */
$GLOBALS['TL_LANG']['tl_proxy']['error_url']    = 'Invalid argument in URL "%s".';
$GLOBALS['TL_LANG']['tl_proxy']['error_scheme'] = 'Scheme "%s" not supported.';
$GLOBALS['TL_LANG']['tl_proxy']['error_local']  = 'Invalid argument "%s" in Proxy exceptions.';

