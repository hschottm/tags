<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

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
 * @copyright  Helmut Schottmüller 2008
 * @author     Helmut Schottmüller <helmut.schottmueller@aurealis.de>
 * @package    tags
 * @license    LGPL
 * @filesource
 */


if (@class_exists("tl_news"))
{

if (is_array($GLOBALS['TL_DCA']['tl_news']['config']['onload_callback']))
{
	foreach ($GLOBALS['TL_DCA']['tl_news']['config']['onload_callback'] as $key => $arr)
	{
		if (is_array($arr) && strcmp($arr[0], 'tl_news') == 0 && strcmp($arr[1], 'generateFeed') == 0)
		{
			$GLOBALS['TL_DCA']['tl_news']['config']['onload_callback'][$key] = array('TagHelper', 'generateNewsFeed');
		}
	}
}


class tl_news_tags extends tl_news
{
	public function deleteNews($dc)
	{
		$this->Database->prepare("DELETE FROM tl_tag WHERE from_table = ? AND id = ?")
			->execute($dc->table, $dc->id);
	}
	
	public function onCopy($dc)
	{
		if (is_array($this->Session->get('tl_news_copy')))
		{
			foreach ($this->Session->get('tl_news_copy') as $data)
			{
				$this->Database->prepare("INSERT INTO tl_tag (id, tag, from_table) VALUES (?, ?, ?)")
					->execute($dc->id, $data['tag'], $data['table']);
			}
		}
		$this->Session->set('tl_news_copy', null);
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
		$this->Session->set("tl_news_copy", $tags);
	}
}

/**
 * Change tl_news palettes
 */
$disabledObjects = deserialize($GLOBALS['TL_CONFIG']['disabledTagObjects'], true);
if (!in_array('tl_news', $disabledObjects))
{
	$GLOBALS['TL_DCA']['tl_news']['config']['ondelete_callback'][] = array('tl_news_tags', 'deleteNews');
	$GLOBALS['TL_DCA']['tl_news']['config']['onload_callback'][] = array('tl_news_tags', 'onCopy');
	$GLOBALS['TL_DCA']['tl_news']['palettes']['default'] = str_replace("author", "author,tags", $GLOBALS['TL_DCA']['tl_news']['palettes']['default']);
	$GLOBALS['TL_DCA']['tl_news']['palettes']['internal'] = str_replace("author", "author,tags", $GLOBALS['TL_DCA']['tl_news']['palettes']['internal']);
	$GLOBALS['TL_DCA']['tl_news']['palettes']['external'] = str_replace("author", "author,tags", $GLOBALS['TL_DCA']['tl_news']['palettes']['external']);
}

$GLOBALS['TL_DCA']['tl_news']['fields']['tags'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['MSC']['tags'],
	'inputType'               => 'tag',
	'eval'                    => array('tl_class'=>'clr long')
);

}

?>