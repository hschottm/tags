<?php

/**
 * Contao Open Source CMS - tags extension
 *
 * Copyright (c) 2008-2016 Helmut Schottmüller
 *
 * @license LGPL-3.0+
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
		$this->Database->prepare("DELETE FROM tl_tag WHERE from_table = ? AND tid = ?")
			->execute($dc->table, $dc->id);
	}
	
	public function onCopy($dc)
	{
		if (is_array($this->Session->get('tl_news_copy')))
		{
			foreach ($this->Session->get('tl_news_copy') as $data)
			{
				$this->Database->prepare("INSERT INTO tl_tag (tid, tag, from_table) VALUES (?, ?, ?)")
					->execute($dc->id, $data['tag'], $data['table']);
			}
		}
		$this->Session->set('tl_news_copy', null);
		if (\Input::get('act') != 'copy')
		{
			return;
		}
		$objTags = $this->Database->prepare("SELECT * FROM tl_tag WHERE tid = ? AND from_table = ?")
			->execute(\Input::get('tid'), $dc->table);
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
	'eval'                    => array('tl_class'=>'clr long'),
	'sql'                     => "char(1) NOT NULL default ''"
);

}

