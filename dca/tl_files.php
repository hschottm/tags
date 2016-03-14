<?php

/**
 * Contao Open Source CMS - tags extension
 *
 * Copyright (c) 2008-2016 Helmut Schottmüller
 *
 * @license LGPL-3.0+
 */

$disabledObjects = deserialize($GLOBALS['TL_CONFIG']['disabledTagObjects'], true);
if (!in_array('tl_files', $disabledObjects))
{
	$GLOBALS['TL_DCA']['tl_files']['palettes']['default'] = str_replace(';meta', ';tags;meta', $GLOBALS['TL_DCA']['tl_files']['palettes']['default']);

	$GLOBALS['TL_DCA']['tl_files']['config']['ondelete_callback'][] = array('tl_files_tags', 'removeContentElement');
	$GLOBALS['TL_DCA']['tl_files']['config']['onload_callback'][] = array('tl_files_tags', 'onCopy');
}

$GLOBALS['TL_DCA']['tl_files']['fields']['tags'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['MSC']['tags'],
	'inputType'               => 'tag',
	'eval'                    => array('tl_class'=>'clr long'),
	'sql'                     => "char(1) NOT NULL default ''"
);

/**
 * Class tl_files_tags
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  Helmut Schottmüller <contao@aurealis.de>
 * @author     Helmut Schottmüller <contao@aurealis.de>
 * @package    Controller
 */
class tl_files_tags extends tl_files
{
	public function removeContentElement($dc)
	{
		$this->Database->prepare("DELETE FROM tl_tag WHERE from_table = ? AND tid = ?")
			->execute($dc->table, $dc->id);
	}

	public function onCopy($dc)
	{
		if (is_array($this->Session->get('tl_files_copy')))
		{
			foreach ($this->Session->get('tl_files_copy') as $data)
			{
				$this->Database->prepare("INSERT INTO tl_tag (tid, tag, from_table) VALUES (?, ?, ?)")
					->execute($dc->id, $data['tag'], $data['table']);
			}
		}
		$this->Session->set('tl_files_copy', null);
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
		$this->Session->set("tl_files_copy", $tags);
	}
}

