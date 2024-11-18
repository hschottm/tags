<?php

/**
 * Contao Open Source CMS - tags extension
 *
 * Copyright (c) 2008-2024 Helmut Schottmüller
 *
 * @license LGPL-3.0+
 */


use Contao\Backend;
use Contao\DataContainer;
use Contao\Database;

if (isset($GLOBALS['TL_CONFIG']['disabledTagObjects'])) {
	$disabledObjects = \Contao\StringUtil::deserialize($GLOBALS['TL_CONFIG']['disabledTagObjects'], true);
} else {
	$disabledObjects = array();
}

if (!in_array('tl_content', $disabledObjects))
{
	foreach ($GLOBALS['TL_DCA']['tl_content']['palettes'] as $key => &$palette)
	{
		if (strcmp($key, '__selector__') != 0)
		{
			$value = $GLOBALS['TL_DCA']['tl_content']['palettes'][$key];
			if (strlen($value) >= 2) {
				$pos = strpos($value, '{', 2);
				if ($pos !== FALSE)
				{
					$GLOBALS['TL_DCA']['tl_content']['palettes'][$key] = substr($GLOBALS['TL_DCA']['tl_content']['palettes'][$key],0,$pos) . "{tags_legend:hide},tags;" . substr($GLOBALS['TL_DCA']['tl_content']['palettes'][$key],$pos);
				}
			}
		}
	}
	unset($palette);

	$GLOBALS['TL_DCA']['tl_content']['palettes']['headline'] = str_replace('guests','guests,tagsonly', $GLOBALS['TL_DCA']['tl_content']['palettes']['headline']);
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
