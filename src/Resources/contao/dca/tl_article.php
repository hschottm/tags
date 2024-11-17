<?php

use Contao\CoreBundle\DataContainer\PaletteManipulator;

/**
 * Contao Open Source CMS - tags extension
 *
 * Copyright (c) 2008-2016 Helmut Schottmüller
 *
 * @license LGPL-3.0+
 */


/**
 * Change tl_article default palette
 */
if (isset($GLOBALS['TL_CONFIG']['disabledTagObjects'])) {
	$disabledObjects = \Contao\StringUtil::deserialize($GLOBALS['TL_CONFIG']['disabledTagObjects'], true);
} else {
	$disabledObjects = array();
}
if (!in_array('tl_article', $disabledObjects)) {
	PaletteManipulator::create()
    ->addLegend('tags_legend', 'layout_legend', PaletteManipulator::POSITION_BEFORE)
    ->addField('tags', 'tags_legend', PaletteManipulator::POSITION_APPEND)
    ->addField('tags_showtags', 'tags_legend', PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('default', 'tl_article');


//	$GLOBALS['TL_DCA']['tl_article']['palettes']['default'] = str_replace("{layout_legend}", "{tags_legend},tags,tags_showtags;{layout_legend}", $GLOBALS['TL_DCA']['tl_article']['palettes']['default']);
	$GLOBALS['TL_DCA']['tl_article']['palettes']['__selector__'][] = 'tags_showtags';
	$GLOBALS['TL_DCA']['tl_article']['subpalettes']['tags_showtags']    = 'tags_max_tags,tags_relevance,tags_jumpto';	
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
	'eval'                    => array('fieldType'=>'radio', 'helpwizard'=>true, 'tl_class'=>'clr'),
	'sql'                     => "smallint(5) unsigned NOT NULL default '0'"
);

