<?php 

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2012 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
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
$GLOBALS['TL_LANG']['tl_settings']['proxy_out_legend'] = "Proxy configuration (outgoing connections)";
$GLOBALS['TL_LANG']['tl_settings']['useProxy'] = array('インターネットのアクセスにプロキシーを使用', 'インターネットに直接接続していない場合に、プロキシーを指定できます。');
$GLOBALS['TL_LANG']['tl_settings']['proxy_url'] = array('プロキシー・サーバのURL', '例: "http://[user:password@]host[:port]" ...');
$GLOBALS['TL_LANG']['tl_settings']['proxy_local'] = array('プロキシーの例外', '例: "localhost, 127.0.0.1, .example.com, 192.168." ...');

/**
 * Error messages
 */
$GLOBALS['TL_LANG']['tl_proxy']['error_url'] = '"%s" は不正なURLです。';
$GLOBALS['TL_LANG']['tl_proxy']['error_scheme'] = '"%s" というスキーマはサポートしていません。';
$GLOBALS['TL_LANG']['tl_proxy']['error_local'] = 'プロキシーの例外にある "%s" は不正なパラメータです。';

