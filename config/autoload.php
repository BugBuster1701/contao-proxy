<?php

/**
 * Contao Open Source CMS
 * 
 * Copyright (C) 2005-2012 Leo Feyer
 * 
 * @package Proxy
 * @link    http://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Classes
	'Proxy'        => 'system/modules/proxy/classes/Proxy.php',
	'ProxyRequest' => 'system/modules/proxy/classes/ProxyRequest.php',
));
