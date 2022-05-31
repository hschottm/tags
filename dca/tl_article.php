<?php

/**
 * Contao Open Source CMS - tags extension
 *
 * Copyright (c) 2008-2016 Helmut Schottmüller
 *
 * @license LGPL-3.0+
 */

class tl_article_tags extends tl_article
{
	public function removeArticle($dc)
	{
		$this->Database->prepare("DELETE FROM tl_tag WHERE from_table = ? AND tid = ?")
			->execute($dc->table, $dc->id);
		$arrContentElements = $this->Database->prepare("SELECT DISTINCT id FROM tl_content WHERE pid = ?")
			->execute($dc->id)->fetchEach('id');
		foreach ($arrContentElements as $cte_id)
		{
			$this->Database->prepare("DELETE FROM tl_tag WHERE from_table = ? AND tid = ?")
				->execute('tl_content', $cte_id);
		}
	}

	public function removePage($dc)
	{
		// remove tags of all articles in the page
		$arrArticles = $this->Database->prepare("SELECT DISTINCT id FROM tl_article WHERE pid = ?")
			->execute($dc->id)->fetchEach('id');
		foreach ($arrArticles as $id)
		{
			$arrContentElements = $this->Database->prepare("SELECT DISTINCT id FROM tl_content WHERE pid = ?")
				->execute($id)->fetchEach('id');
			foreach ($arrContentElements as $cte_id)
			{
				$this->Database->prepare("DELETE FROM tl_tag WHERE from_table = ? AND tid = ?")
					->execute('tl_content', $cte_id);
			}
			$this->Database->prepare("DELETE FROM tl_tag WHERE from_table = ? AND tid = ?")
				->execute('tl_article', $id);
		}
	}

	public function onCopy($dc)
	{
		if (is_array($this->Session->get('tl_article_copy')))
		{
			foreach ($this->Session->get('tl_article_copy') as $data)
			{
				$this->Database->prepare("INSERT INTO tl_tag (tid, tag, from_table) VALUES (?, ?, ?)")
					->execute($dc->id, $data['tag'], $data['table']);
			}
		}
		$this->Session->set('tl_article_copy', null);
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
		$this->Session->set("tl_article_copy", $tags);
	}
}


/**
 * Change tl_article default palette
 */

$disabledObjects = deserialize($GLOBALS['TL_CONFIG']['disabledTagObjects'], true);
if (!in_array('tl_article', $disabledObjects))
{
	$GLOBALS['TL_DCA']['tl_article']['palettes']['default'] = str_replace("keywords", "keywords;{tags_legend},tags,tags_showtags", $GLOBALS['TL_DCA']['tl_article']['palettes']['default']);
	$GLOBALS['TL_DCA']['tl_article']['palettes']['__selector__'][] = 'tags_showtags';
	$GLOBALS['TL_DCA']['tl_article']['subpalettes']['tags_showtags']    = 'tags_max_tags,tags_relevance,tags_jumpto';
	$GLOBALS['TL_DCA']['tl_article']['config']['ondelete_callback'][] = array('tl_article_tags', 'removeArticle');
	$GLOBALS['TL_DCA']['tl_page']['config']['ondelete_callback'][] = array('tl_article_tags', 'removePage');
	$GLOBALS['TL_DCA']['tl_article']['config']['onload_callback'][] = array('tl_article_tags', 'onCopy');
}

$GLOBALS['TL_DCA']['tl_article']['fields']['tags'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['MSC']['tags'],
	'inputType'               => 'tag',
	'eval'                    => array('tl_class'=>'clr long'),
	'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_article']['fields']['tags_showtags'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_article']['tags_showtags'],
	'inputType'               => 'checkbox',
	'eval'                    => array('submitOnChange'=>true, 'tl_class'=>'clr m12'),
	'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_article']['fields']['tags_max_tags'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_article']['tags_max_tags'],
	'default'                 => '0',
	'inputType'               => 'text',
	'eval'                    => array('maxlength'=>5, 'rgxp' => 'digit', 'tl_class'=>'w50'),
	'sql'                     => "smallint(5) unsigned NOT NULL default '0'"
);

$GLOBALS['TL_DCA']['tl_article']['fields']['tags_relevance'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_article']['tags_relevance'],
	'inputType'               => 'checkbox',
	'eval'                    => array('tl_class'=>'w50 m12'),
	'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_article']['fields']['tags_jumpto'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_article']['tags_jumpto'],
	'inputType'               => 'pageTree',
	'explanation'             => 'jumpTo',
	'eval'                    => array('fieldType'=>'radio', 'helpwizard'=>true),
	'sql'                     => "smallint(5) unsigned NOT NULL default '0'"
);

