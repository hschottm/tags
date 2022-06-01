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
if (!in_array('tl_files', $disabledObjects))
{
	$GLOBALS['TL_DCA']['tl_files']['palettes']['default'] = str_replace(';meta', ';tags;meta', $GLOBALS['TL_DCA']['tl_files']['palettes']['default']);

	$GLOBALS['TL_DCA']['tl_files']['config']['ondelete_callback'][] = array('tl_files_tags', 'removeContentElement');
	$GLOBALS['TL_DCA']['tl_files']['config']['oncopy_callback'][] = array('tl_files_tags', 'onCopy');
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
 * @copyright  Helmut Schottmüller <https://github.com/hschottm>
 * @author     Helmut Schottmüller <https://github.com/hschottm>
 * @package    Controller
 */
class tl_files_tags extends \Backend
{
	public function removeContentElement($source, \DataContainer $dc)
	{ 
        $fileModel = \FilesModel::findByPath($source);
		if ($fileModel != null) {
			$this->Database->prepare("DELETE FROM tl_tag WHERE from_table = ? AND tid = ?")
			->execute($dc->table, $fileModel->id);
		}
	}

    public function onCopy($source, $destination, \DataContainer $dc)
    {
        $sourceModel = \FilesModel::findByPath($source);
        $destModel = \FilesModel::findByPath($destination);

        if ($sourceModel != null && $destModel != null) {
            $objTags = $this->Database->prepare("SELECT * FROM tl_tag WHERE tid = ? AND from_table = ?")->execute($sourceModel->id, $dc->table);
            $tags = array();
            while ($objTags->next()) {
                \array_push($tags, array("table" => $dc->table, "tag" => $objTags->tag));
            }
            foreach ($tags as $entry) {
                $this->Database->prepare("INSERT INTO tl_tag (tid, tag, from_table) VALUES (?, ?, ?)")->execute($destModel->id, $entry['tag'], $entry['table']);
            }
        }
    }
}

