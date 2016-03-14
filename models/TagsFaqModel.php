<?php

/**
 * Contao Open Source CMS - tags extension
 *
 * Copyright (c) 2008-2016 Helmut Schottmüller
 *
 * @license LGPL-3.0+
 */

namespace Contao;

class TagsFaqModel extends \FaqModel
{
	/**
	 * Find all published FAQs by their parent IDs
	 * 
	 * @param array $arrPids    An array of FAQ category IDs
	 * @param array $arrOptions An optional options array
	 * 
	 * @return \Model\Collection|null A collection of models or null if there are no FAQs
	 */
	public static function findPublishedByPidsAndIds($arrPids, $arrIds, array $arrOptions=array())
	{
		if (!is_array($arrPids) || empty($arrPids))
		{
			return null;
		}

		$t = static::$strTable;
		$arrColumns = array("$t.pid IN(" . implode(',', array_map('intval', $arrPids)) . ")");
		if (is_array($arrIds) && count($arrIds) > 0) $arrColumns[] = "$t.id IN(" . implode(',', array_map('intval', $arrIds)) . ")";

		if (!BE_USER_LOGGED_IN)
		{
			$arrColumns[] = "$t.published=1";
		}

		if (!isset($arrOptions['order']))
		{
			$arrOptions['order'] = "$t.pid, $t.sorting";
		}

		return static::findBy($arrColumns, null, $arrOptions);
	}
}
