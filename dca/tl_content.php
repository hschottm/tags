<?php

/**
 * Contao Open Source CMS - tags extension
 *
 * Copyright (c) 2008-2016 Helmut Schottmüller
 *
 * @license LGPL-3.0+
 */

if (isset($GLOBALS['TL_CONFIG']['disabledTagObjects'])) {
	$disabledObjects = deserialize($GLOBALS['TL_CONFIG']['disabledTagObjects'], true);
} else {
	$disabledObjects = array();
}
if (!in_array('tl_content', $disabledObjects))
{
	foreach ($GLOBALS['TL_DCA']['tl_content']['palettes'] as $key => $palette)
	{
		if (strcmp($key, '__selector__') != 0)
		{
			$pos = strpos($GLOBALS['TL_DCA']['tl_content']['palettes'][$key], '{', 2);
			if ($pos !== FALSE)
			{
				$GLOBALS['TL_DCA']['tl_content']['palettes'][$key] = substr($GLOBALS['TL_DCA']['tl_content']['palettes'][$key],0,$pos) . "{tags_legend:hide},tags;" . substr($GLOBALS['TL_DCA']['tl_content']['palettes'][$key],$pos);
			}
		}
	}

	$GLOBALS['TL_DCA']['tl_content']['palettes']['headline'] = str_replace('guests','guests,tagsonly', $GLOBALS['TL_DCA']['tl_content']['palettes']['headline']);
	$GLOBALS['TL_DCA']['tl_content']['config']['ondelete_callback'][] = array('tl_content_tags', 'removeContentElement');
	$GLOBALS['TL_DCA']['tl_content']['config']['oncopy_callback'][] = array('tl_content_tags', 'onCopy');
	$GLOBALS['TL_DCA']['tl_content']['palettes']['gallery'] = str_replace('numberOfItems','numberOfItems,tag_filter,tag_ignore;', $GLOBALS['TL_DCA']['tl_content']['palettes']['gallery']);
}

$GLOBALS['TL_DCA']['tl_content']['fields']['tagsonly'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['tagsonly'],
	'inputType'               => 'checkbox',
	'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['tags'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['MSC']['tags'],
	'inputType'               => 'tag',
	'eval'                    => array('tl_class'=>'clr long'),
	'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['tag_filter'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['tag_filter'],
	'inputType'               => 'text',
	'eval'                    => array('maxlength'=>1000, 'tl_class' => 'w50'),
	'sql'                     => "varchar(1000) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['tag_ignore'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['tag_ignore'],
	'inputType'               => 'checkbox',
	'eval'                    => array('tl_class' => 'w50 m12'),
	'sql'                     => "char(1) NOT NULL default ''"
);

/**
 * Class tl_content_tags
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  Helmut Schottmüller 2009
 * @author     Helmut Schottmüller <https://github.com/hschottm>
 * @package    Controller
 */
class tl_content_tags extends \Backend
{
	public function removeContentElement(\DataContainer $dc, $undoId)
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

