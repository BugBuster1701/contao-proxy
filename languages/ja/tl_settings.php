<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

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
 * @copyright  Takahiro Kambe 2008
 * @author     Takahiro Kambe <taca@back-street.net>
 * @package    Proxy
 * @license    LGPL
 */

/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_settings']['useProxy'] = array('インターネットのアクセスにプロキシーを使用', 'インターネットに直接接続していない場合に、プロキシーを指定できます。');
$GLOBALS['TL_LANG']['tl_settings']['proxy_url'] = array('プロキシー・サーバのURL', '例: "http://[user:passwort@]host[:port]" ...');
$GLOBALS['TL_LANG']['tl_settings']['proxy_local'] = array('プロキシーの例外', '例: "localhost, 127.0.0.1, .example.com, 192.168." ...');

/**
 * Error messages
 */
$GLOBALS['TL_LANG']['tl_proxy']['error_url'] = '"%s" は不正なURLです。';
$GLOBALS['TL_LANG']['tl_proxy']['error_scheme'] = '"%s" というスキーマはサポートしていません。';
$GLOBALS['TL_LANG']['tl_proxy']['error_local'] = 'プロキシーの例外にある "%s" は不正なパラメータです。';

?>