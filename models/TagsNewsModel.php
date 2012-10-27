<?php

/**
 * Contao Open Source CMS
 * 
 * Copyright (C) 2005-2012 Leo Feyer
 * 
 * @package News
 * @link    http://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace Contao;


/**
 * Reads and writes news
 * 
 * @package   Models
 * @author    Leo Feyer <https://github.com/leofeyer>
 * @copyright Leo Feyer 2011-2012
 */
class TagsNewsModel extends \NewsModel
{
	/**
	 * Count published news items by their parent ID
	 * 
	 * @param array   $arrPids     An array of news archive IDs
	 * @param boolean $blnFeatured If true, return only featured news, if false, return only unfeatured news
	 * 
	 * @return integer The number of news items
	 */
	public static function countPublishedByPidsAndIds($arrPids, $arrIds, $blnFeatured=null)
	{
		if (!is_array($arrPids) || empty($arrPids))
		{
			return 0;
		}

		$t = static::$strTable;
		$arrColumns = array("$t.pid IN(" . implode(',', array_map('intval', $arrPids)) . ")");
		$arrColumns[] = "$t.id IN(" . implode(',', array_map('intval', $arrIds)) . ")";
		if ($blnFeatured === true)
		{
			$arrColumns[] = "$t.featured=1";
		}
		elseif ($blnFeatured === false)
		{
			$arrColumns[] = "$t.featured=''";
		}

		if (!BE_USER_LOGGED_IN)
		{
			$time = time();
			$arrColumns[] = "($t.start='' OR $t.start<$time) AND ($t.stop='' OR $t.stop>$time) AND $t.published=1";
		}

		return static::countBy($arrColumns, null);
	}

	/**
	 * Find published news items by their parent ID
	 * 
	 * @param array   $arrPids     An array of news archive IDs
	 * @param boolean $blnFeatured If true, return only featured news, if false, return only unfeatured news
	 * @param integer $intLimit    An optional limit
	 * @param integer $intOffset   An optional offset
	 * 
	 * @return \Model\Collection|null A collection of models or null if there are no news
	 */
	public static function findPublishedByPidsAndIds($arrPids, $arrIds, $blnFeatured=null, $intLimit=0, $intOffset=0)
	{
		if (!is_array($arrPids) || empty($arrPids))
		{
			return null;
		}

		$t = static::$strTable;
		$arrColumns = array("$t.pid IN(" . implode(',', array_map('intval', $arrPids)) . ")");
		$arrColumns[] = "$t.id IN(" . implode(',', array_map('intval', $arrIds)) . ")";

		if ($blnFeatured === true)
		{
			$arrColumns[] = "$t.featured=1";
		}
		elseif ($blnFeatured === false)
		{
			$arrColumns[] = "$t.featured=''";
		}

		// Never return unpublished elements in the back end, so they don't end up in the RSS feed
		if (!BE_USER_LOGGED_IN || TL_MODE == 'BE')
		{
			$time = time();
			$arrColumns[] = "($t.start='' OR $t.start<$time) AND ($t.stop='' OR $t.stop>$time) AND $t.published=1";
		}

		$arrOptions = array
		(
			'order'  => "$t.date DESC",
			'limit'  => $intLimit,
			'offset' => $intOffset
		);

		return static::findBy($arrColumns, null, $arrOptions);
	}

	/**
	 * Count all published news items of a certain period of time by their parent ID
	 * 
	 * @param integer $intFrom The start date as Unix timestamp
	 * @param integer $intTo   The end date as Unix timestamp
	 * @param array   $arrPids An array of news archive IDs
	 * 
	 * @return integer The number of news items
	 */
	public static function countPublishedFromToByPidsAndIds($intFrom, $intTo, $arrPids, $arrIds)
	{
		if (!is_array($arrPids) || empty($arrPids))
		{
			return null;
		}

		$t = static::$strTable;
		$arrColumns = array("$t.date>=? AND $t.date<=? AND $t.pid IN(" . implode(',', array_map('intval', $arrPids)) . ")");
		$arrColumns[] = "$t.id IN(" . implode(',', array_map('intval', $arrIds)) . ")";

		if (!BE_USER_LOGGED_IN)
		{
			$time = time();
			$arrColumns[] = "($t.start='' OR $t.start<$time) AND ($t.stop='' OR $t.stop>$time) AND $t.published=1";
		}

		return static::countBy($arrColumns, array($intFrom, $intTo));
	}

	/**
	 * Find all published news items of a certain period of time by their parent ID
	 * 
	 * @param integer $intFrom   The start date as Unix timestamp
	 * @param integer $intTo     The end date as Unix timestamp
	 * @param array   $arrPids   An array of news archive IDs
	 * @param integer $intLimit  An optional limit
	 * @param integer $intOffset An optional offset
	 * 
	 * @return \Model\Collection|null A collection of models or null if there are no news
	 */
	public static function findPublishedFromToByPidsAndIds($intFrom, $intTo, $arrPids, $arrIds, $intLimit=0, $intOffset=0)
	{
		if (!is_array($arrPids) || empty($arrPids))
		{
			return null;
		}

		$t = static::$strTable;
		$arrColumns = array("$t.date>=? AND $t.date<=? AND $t.pid IN(" . implode(',', array_map('intval', $arrPids)) . ")");
		$arrColumns[] = "$t.id IN(" . implode(',', array_map('intval', $arrIds)) . ")";

		if (!BE_USER_LOGGED_IN)
		{
			$time = time();
			$arrColumns[] = "($t.start='' OR $t.start<$time) AND ($t.stop='' OR $t.stop>$time) AND $t.published=1";
		}

		$arrOptions = array
		(
			'order'  => "$t.date DESC",
			'limit'  => $intLimit,
			'offset' => $intOffset
		);

		return static::findBy($arrColumns, array($intFrom, $intTo), $arrOptions);
	}
}
