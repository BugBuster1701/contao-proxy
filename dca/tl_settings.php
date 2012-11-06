<?php 

/**
 * TYPOlight webCMS
 * Copyright (C) 2005 Leo Feyer
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 2.1 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at http://www.gnu.org/licenses/.
 *
 * PHP version 5
 * @copyright  Jörg Kleuver 2008
 * @author     Jörg Kleuver <joerg@kleuver.de>
 * @package    Proxy
 * @license    LGPL
 */

/**
 * Add to palette
 */
$GLOBALS['TL_DCA']['tl_settings']['palettes']['__selector__'][] = 'useProxy';
//$GLOBALS['TL_DCA']['tl_settings']['palettes']['default'] = str_replace('useSMTP;', 'useSMTP;{proxy_legend:hide},useProxy;', $GLOBALS['TL_DCA']['tl_settings']['palettes']['default']);
$GLOBALS['TL_DCA']['tl_settings']['palettes']['default'] .= ';{proxy_legend:hide},useProxy;';


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

$GLOBALS['TL_DCA']['tl_settings']['fields']['proxy_local'] = array(
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
