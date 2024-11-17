<?php

use Contao\Backend;
use Contao\DataContainer;
use Contao\FilesModel;
use Contao\Database;
use Contao\CoreBundle\DataContainer\PaletteManipulator;

/**
 * Contao Open Source CMS - tags extension
 *
 * Copyright (c) 2008-2024 Helmut Schottmüller
 *
 * @license LGPL-3.0+
 */

if (isset($GLOBALS['TL_CONFIG']['disabledTagObjects'])) {
	$disabledObjects = \Contao\StringUtil::deserialize($GLOBALS['TL_CONFIG']['disabledTagObjects'], true);
} else {
	$disabledObjects = array();
}
if (!in_array('tl_files', $disabledObjects))
{
	PaletteManipulator::create()
    ->addLegend('tags_legend', 'meta', PaletteManipulator::POSITION_AFTER)
    ->addField('tags', 'tags_legend', PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('default', 'tl_files');

    //$GLOBALS['TL_DCA']['tl_files']['palettes']['default'] = str_replace(';meta', ';tags;meta', $GLOBALS['TL_DCA']['tl_files']['palettes']['default']);

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
