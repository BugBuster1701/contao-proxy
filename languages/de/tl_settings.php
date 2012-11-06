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
$GLOBALS['TL_LANG']['tl_settings']['proxy_legend'] = "Proxy-Einstellungen";
$GLOBALS['TL_LANG']['tl_settings']['useProxy']     = array('Proxy für Webzugriffe verwenden', 'Wenn kein direkter Zugriff auf das Internet vorhanden ist, können Sie einen Proxy angeben.');
$GLOBALS['TL_LANG']['tl_settings']['proxy_url']    = array('URL des Proxy Servers', 'Beispiel: "http://[user:passwort@]host[:port]" ...');
$GLOBALS['TL_LANG']['tl_settings']['proxy_local']  = array('kein Proxy für', 'Beispiel: "localhost, 127.0.0.1, .example.com, 192.168." ...');

/**
 * Error messages
 */
$GLOBALS['TL_LANG']['tl_proxy']['error_url']    = 'Ungültiger Eintrag in URL "%s".';
$GLOBALS['TL_LANG']['tl_proxy']['error_scheme'] = 'Schema "%s" wird nicht unterstützt.';
$GLOBALS['TL_LANG']['tl_proxy']['error_local']  = 'Ungültiger Eintrag "%s" in den Proxy Ausnahmen.';

