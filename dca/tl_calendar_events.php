<?php

/**
 * Contao Open Source CMS - tags extension
 *
 * Copyright (c) 2008-2016 Helmut Schottmüller
 *
 * @license LGPL-3.0+
 */

if (@class_exists("tl_calendar_events"))
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

class tl_calendar_events_tags extends \Backend
{
	public function deleteEvents(\DataContainer $dc, $undoId)
	{
		$this->Database->prepare("DELETE FROM tl_tag WHERE from_table = ? AND tid = ?")
			->execute($dc->table, $dc->id);
	}
	
    public function onCopy($insertID, \DataContainer $dc)
    {
		$objTags = $this->Database->prepare("SELECT * FROM tl_tag WHERE tid = ? AND from_table = ?")->execute($dc->id, $dc->table);
		$tags = array();
		while ($objTags->next()) {
			\array_push($tags, array("table" => $dc->table, "tag" => $objTags->tag));
		}
		foreach ($tags as $entry) {
			$this->Database->prepare("INSERT INTO tl_tag (tid, tag, from_table) VALUES (?, ?, ?)")->execute($insertID, $entry['tag'], $entry['table']);
		}
	}
}

/**
 * Change tl_news palettes
 */
if (isset($GLOBALS['TL_CONFIG']['disabledTagObjects'])) {
	$disabledObjects = deserialize($GLOBALS['TL_CONFIG']['disabledTagObjects'], true);
} else {
	$disabledObjects = array();
}
if (!in_array('tl_calendar_events', $disabledObjects))
{
	$GLOBALS['TL_DCA']['tl_calendar_events']['config']['ondelete_callback'][] = array('tl_calendar_events_tags', 'deleteEvents');
	$GLOBALS['TL_DCA']['tl_calendar_events']['config']['oncopy_callback'][] = array('tl_calendar_events_tags', 'onCopy');
	$GLOBALS['TL_DCA']['tl_calendar_events']['palettes']['default'] = str_replace("author", "author,tags", $GLOBALS['TL_DCA']['tl_calendar_events']['palettes']['default']);
}
$GLOBALS['TL_DCA']['tl_calendar_events']['fields']['tags'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['MSC']['tags'],
	'inputType'               => 'tag',
	'eval'                    => array('tl_class'=>'clr long'),
	'sql'                     => "char(1) NOT NULL default ''"
);

}

