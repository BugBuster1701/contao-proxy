<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2013 Leo Feyer
 *
 * @package Proxy
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Classes
	'ProxyRequest' => 'system/modules/proxy/classes/ProxyRequest.php',
	'Proxy'        => 'system/modules/proxy/classes/Proxy.php',
	'DcaProxy'     => 'system/modules/proxy/classes/DcaProxy.php',
));
