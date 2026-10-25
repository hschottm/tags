<?php

use Contao\Backend;
use Contao\DataContainer;
use Contao\Database;
use Contao\StringUtil;

/**
 * Contao Open Source CMS - tags extension
 *
 * Copyright (c) 2008-2024 Helmut Schottmüller
 *
 * @license LGPL-3.0+
 */


if (array_key_exists('tl_calendar_events', $GLOBALS['TL_DCA'])) {


	/**
	 * Change tl_calendar_events palettes
	 */
	if (isset($GLOBALS['TL_CONFIG']['disabledTagObjects'])) {
		$disabledObjects = StringUtil::deserialize($GLOBALS['TL_CONFIG']['disabledTagObjects'], true);
	} else {
		$disabledObjects = array();
	}
	if (!in_array('tl_calendar_events', $disabledObjects))
	{
		if (array_key_exists('tl_calendar_events', $GLOBALS['TL_DCA'])) {
			$GLOBALS['TL_DCA']['tl_calendar_events']['palettes']['default'] = str_replace("author", "author,tags", $GLOBALS['TL_DCA']['tl_calendar_events']['palettes']['default']);
		}
	}
	$GLOBALS['TL_DCA']['tl_calendar_events']['fields']['tags'] = array
	(
		'label'                   => &$GLOBALS['TL_LANG']['MSC']['tags'],
		'inputType'               => 'tag',
		'eval'                    => array('tl_class'=>'clr long'),
		'sql'                     => "char(1) NOT NULL default ''"
	);

}

