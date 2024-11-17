<?php

use Contao\Backend;
use Contao\DataContainer;
use Contao\Database;

/**
 * Contao Open Source CMS - tags extension
 *
 * Copyright (c) 2008-2016 Helmut Schottmüller
 *
 * @license LGPL-3.0+
 */

if (array_key_exists('tl_faq', $GLOBALS['TL_DCA']))
{
	/**
	 * Change tl_faq default palette
	 */

	if (isset($GLOBALS['TL_CONFIG']['disabledTagObjects'])) {
		$disabledObjects = \Contao\StringUtil::deserialize($GLOBALS['TL_CONFIG']['disabledTagObjects'], true);
	} else {
		$disabledObjects = array();
	}
	if (!in_array('tl_article', $disabledObjects))
	{
		if (array_key_exists('tl_faq', $GLOBALS['TL_DCA'])) {
			$GLOBALS['TL_DCA']['tl_faq']['palettes']['default'] = str_replace("author", "author,tags", $GLOBALS['TL_DCA']['tl_faq']['palettes']['default']);
		}
	}

	$GLOBALS['TL_DCA']['tl_faq']['fields']['tags'] = array
	(
		'label'                   => &$GLOBALS['TL_LANG']['MSC']['tags'],
		'inputType'               => 'tag',
		'eval'                    => array('tl_class'=>'clr long'),
		'sql'                     => "char(1) NOT NULL default ''"
		);
}
