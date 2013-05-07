<?php

/**
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
 * @copyright  Helmut Schottmüller 2008
 * @author     Helmut Schottmüller <helmut.schottmueller@aurealis.de>
 * @package    tags
 * @license    LGPL
 * @filesource
 */

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
		$this->Database->prepare("DELETE FROM tl_tag WHERE from_table = ? AND id = ?")
			->execute($dc->table, $dc->id);
	}
	
	public function onCopy($dc)
	{
		if (is_array($this->Session->get('tl_calendar_events_copy')))
		{
			foreach ($this->Session->get('tl_calendar_events_copy') as $data)
			{
				$this->Database->prepare("INSERT INTO tl_tag (id, tag, from_table) VALUES (?, ?, ?)")
					->execute($dc->id, $data['tag'], $data['table']);
			}
		}
		$this->Session->set('tl_calendar_events_copy', null);
		if (\Input::get('act') != 'copy')
		{
			return;
		}
		$objTags = $this->Database->prepare("SELECT * FROM tl_tag WHERE id = ? AND from_table = ?")
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
	'eval'                    => array('tl_class'=>'clr long')
);

}

?>