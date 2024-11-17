<?php

/**
 * @copyright  Helmut Schottmüller 2008-2024
 * @author     Helmut Schottmüller <https://github.com/hschottm/tags_members>
 * @package    tags_members
 * @license    LGPL
 * @filesource
 */

use Contao\Backend;
use Contao\DataContainer;
use Contao\Database;

/**
 * Change tl_member palettes
 */
if (isset($GLOBALS['TL_CONFIG']['disabledTagObjects'])) {
	$disabledObjects = \Contao\StringUtil::deserialize($GLOBALS['TL_CONFIG']['disabledTagObjects'], true);
} else {
	$disabledObjects = array();
}

if (!in_array('tl_member', $disabledObjects))
{
	if (array_key_exists('tl_member', $GLOBALS['TL_DCA'])) {
		PaletteManipulator::create()
			->addLegend('tags_legend', 'address_legend', PaletteManipulator::POSITION_BEFORE)
			->addField('tags', 'tags_legend', PaletteManipulator::POSITION_APPEND)
			->applyToPalette('default', 'tl_member');
	}
}

$GLOBALS['TL_DCA']['tl_member']['fields']['tags'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['MSC']['tags'],
	'inputType'               => 'tag',
	'eval'                    => array('tl_class'=>'clr long', 'feEditable' => true, 'feGroup' => 'personal'),
	'sql'                     => "char(1) NOT NULL default ''"
);
