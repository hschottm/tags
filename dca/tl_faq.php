<?php

/**
 * Contao Open Source CMS - tags extension
 *
 * Copyright (c) 2008-2016 Helmut Schottmüller
 *
 * @license LGPL-3.0+
 */

if (@class_exists("tl_faq"))
{
	/**
	 * Change tl_faq default palette
	 */

	if (isset($GLOBALS['TL_CONFIG']['disabledTagObjects'])) {
		$disabledObjects = deserialize($GLOBALS['TL_CONFIG']['disabledTagObjects'], true);
	} else {
		$disabledObjects = array();
	}
	if (!in_array('tl_article', $disabledObjects))
	{
		if (array_key_exists('tl_faq', $GLOBALS['TL_DCA'])) {
			$GLOBALS['TL_DCA']['tl_faq']['palettes']['default'] = str_replace("author", "author,tags", $GLOBALS['TL_DCA']['tl_faq']['palettes']['default']);
		}
		$GLOBALS['TL_DCA']['tl_faq']['config']['ondelete_callback'][] = array('tl_faq_tags', 'removeFAQ');
		$GLOBALS['TL_DCA']['tl_faq']['config']['oncopy_callback'][] = array('tl_faq_tags', 'onCopy');
	}

	$GLOBALS['TL_DCA']['tl_faq']['fields']['tags'] = array
	(
		'label'                   => &$GLOBALS['TL_LANG']['MSC']['tags'],
		'inputType'               => 'tag',
		'eval'                    => array('tl_class'=>'clr long'),
		'sql'                     => "char(1) NOT NULL default ''"
		);

	class tl_faq_tags extends \Backend
	{
		public function removeFAQ(\DataContainer $dc, $undoId)
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

}
