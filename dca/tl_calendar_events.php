<?php

if (@class_exists("tl_calendar_events"))
{

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

class tl_calendar_events_tags extends tl_calendar_events
{
	public function deleteEvents($dc)
	{
		$this->Database->prepare("DELETE FROM tl_tag WHERE from_table = ? AND tid = ?")
			->execute($dc->table, $dc->id);
	}
	
	public function onCopy($dc)
	{
		if (is_array($this->Session->get('tl_calendar_events_copy')))
		{
			foreach ($this->Session->get('tl_calendar_events_copy') as $data)
			{
				$this->Database->prepare("INSERT INTO tl_tag (tid, tag, from_table) VALUES (?, ?, ?)")
					->execute($dc->id, $data['tag'], $data['table']);
			}
		}
		$this->Session->set('tl_calendar_events_copy', null);
		if (\Input::get('act') != 'copy')
		{
			return;
		}
		$objTags = $this->Database->prepare("SELECT * FROM tl_tag WHERE tid = ? AND from_table = ?")
			->execute(\Input::get('id'), $dc->table);
		$tags = array();
		while ($objTags->next())
		{
			array_push($tags, array("table" => $dc->table, "tag" => $objTags->tag));
		}
		$this->Session->set("tl_calendar_events_copy", $tags);
	}
}

/**
 * Change tl_news palettes
 */
$disabledObjects = deserialize($GLOBALS['TL_CONFIG']['disabledTagObjects'], true);
if (!in_array('tl_calendar_events', $disabledObjects))
{
	$GLOBALS['TL_DCA']['tl_calendar_events']['config']['ondelete_callback'][] = array('tl_calendar_events_tags', 'deleteEvents');
	$GLOBALS['TL_DCA']['tl_calendar_events']['config']['onload_callback'][] = array('tl_calendar_events_tags', 'onCopy');
	$GLOBALS['TL_DCA']['tl_calendar_events']['palettes']['default'] = str_replace("author", "author,tags", $GLOBALS['TL_DCA']['tl_calendar_events']['palettes']['default']);
	$GLOBALS['TL_DCA']['tl_calendar_events']['palettes']['internal'] = str_replace("author", "author,tags", $GLOBALS['TL_DCA']['tl_calendar_events']['palettes']['internal']);
	$GLOBALS['TL_DCA']['tl_calendar_events']['palettes']['external'] = str_replace("author", "author,tags", $GLOBALS['TL_DCA']['tl_calendar_events']['palettes']['external']);
}
$GLOBALS['TL_DCA']['tl_calendar_events']['fields']['tags'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['MSC']['tags'],
	'inputType'               => 'tag',
	'eval'                    => array('tl_class'=>'clr long'),
	'sql'                     => "char(1) NOT NULL default ''"
);

}

