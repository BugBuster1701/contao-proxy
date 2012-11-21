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

