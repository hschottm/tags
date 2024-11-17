<?php

use Contao\Backend;
use Contao\DataContainer;
use Contao\Database;

/**
 * Contao Open Source CMS - tags extension
 *
 * Copyright (c) 2008-2024 Helmut Schottmüller
 *
 * @license LGPL-3.0+
 */

 if (array_key_exists('tl_calendar_events', $GLOBALS['TL_DCA']))
 {

	/*
if (is_array($GLOBALS['TL_DCA']['tl_calendar_events']['config']['onload_callback']))
{
	foreach ($GLOBALS['TL_DCA']['tl_calendar_events']['config']['onload_callback'] as $key => $arr)
	{
		if (is_array($arr) && strcmp($arr[0], 'tl_calendar_events') == 0 && strcmp($arr[1], 'generateFeed') == 0)
		{
//			$GLOBALS['TL_DCA']['tl_calendar_events']['config']['onload_callback'][$key] = array('TagHelper', 'generateEventFeed');
		}
	}
}
*/


	/**
	 * Change tl_calendar_events palettes
	 */
	if (isset($GLOBALS['TL_CONFIG']['disabledTagObjects'])) {
		$disabledObjects = \Contao\StringUtil::deserialize($GLOBALS['TL_CONFIG']['disabledTagObjects'], true);
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

