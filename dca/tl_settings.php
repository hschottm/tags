<?php

/**
 * Contao Open Source CMS - tags extension
 *
 * Copyright (c) 2008-2016 Helmut Schottmüller
 *
 * @license LGPL-3.0+
 */

$GLOBALS['TL_DCA']['tl_settings']['palettes']['default'] .= ';{tags_legend},disabledTagObjects'; 

/**
 * Add fields
 */
$GLOBALS['TL_DCA']['tl_settings']['fields']['disabledTagObjects'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['disabledTagObjects'],
	'inputType'               => 'checkbox',
	'options_callback'        => array('tl_settings_tags', 'getTagTables'),
	'eval'                    => array('multiple'=>true)
);

class tl_settings_tags
{
	/**
	 * Return available tag tables
	 *
	 * @return array Array of tag tables
	 */
	public function getTagTables()
	{
		$tables = array();
		foreach ($GLOBALS['tags_extension']['sourcetable'] as $sourcetable)
		{
			$tables[$sourcetable] = $sourcetable;
		}
		return $tables;
	}
}

