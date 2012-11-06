<?php 

/**
 * TYPOlight webCMS
 *
 * The TYPOlight webCMS is an accessible web content management system that 
 * specializes in accessibility and generates W3C-compliant HTML code. It 
 * provides a wide range of functionality to develop professional websites 
 * including a built-in search engine, form generator, file and user manager, 
 * CSS engine, multi-language support and many more. For more information and 
 * additional TYPOlight applications like the TYPOlight MVC Framework please 
 * visit the project website http://www.typolight.org.
 *
 * PHP version 5
 * @copyright  Jörg Kleuver 2008
 * @author     Jörg Kleuver <joerg@kleuver.de>
 * @package    Proxy
 * @license    LGPL
 */

/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_settings']['proxy_legend'] = "Proxy configuration";
$GLOBALS['TL_LANG']['tl_settings']['useProxy'] = array('Use Proxy to access the Internet', 'If no direct connetion to the internet is possible, you can define a proxy.');
$GLOBALS['TL_LANG']['tl_settings']['proxy_url'] = array('URL of Proxy Server', 'Example: "http://[user:passwort@]host[:port]" ...');
$GLOBALS['TL_LANG']['tl_settings']['proxy_local'] = array('No Proxy for', 'Example: "localhost, 127.0.0.1, .example.com, 192.168." ...');

/**
 * Error messages
 */
$GLOBALS['TL_LANG']['tl_proxy']['error_url'] = 'Invalid argument in URL "%s".';
$GLOBALS['TL_LANG']['tl_proxy']['error_scheme'] = 'Scheme "%s" not supported.';
$GLOBALS['TL_LANG']['tl_proxy']['error_local'] = 'Invalid argument "%s" in Proxy exceptions.';

