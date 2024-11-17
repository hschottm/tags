<?php

use Contao\Backend;
use Contao\DataContainer;

/**
 * Contao Open Source CMS - tags extension
 *
 * Copyright (c) 2008-2024 Helmut Schottmüller
 *
 * @license LGPL-3.0+
 */


/**
 * Change tl_news palettes
 */
if (isset($GLOBALS['TL_CONFIG']['disabledTagObjects'])) {
	$disabledObjects = \Contao\StringUtil::deserialize($GLOBALS['TL_CONFIG']['disabledTagObjects'], true);
} else {
	$disabledObjects = array();
}

if (!in_array('tl_news', $disabledObjects))
{
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


