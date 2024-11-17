<?php

/**
 * Contao Open Source CMS - tags extension
 *
 * Copyright (c) 2008-2024 Helmut Schottmüller
 *
 * @license LGPL-3.0+
 */

namespace Hschottm\TagsBundle;

use \Contao\Model;

class TagModel extends Model
{

	/**
	 * Table name
	 * @var string
	 */
	protected static $strTable = 'tl_tag';


	/**
	 * Find multiple tag results by their IDs and source tables
	 * 
	 * @param int $id ID of the element
	 * @param string $table Table name of the element
	 * 
	 * @return \Model\Collection|null A collection of models or null if there are no calendars
	 */
	public static function findByIdAndTable($id, $table)
	{
		return static::findBy(array('tid=?','from_table=?'), array($id, $table), array('order'=>'tag ASC'));
	}
}
