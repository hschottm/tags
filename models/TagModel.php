<?php

/**
 * Contao Open Source CMS
 * 
 * Copyright (C) 2005-2012 Leo Feyer
 * 
 * @package tags
 * @link    http://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace Contao;


/**
 * Reads and writes calendars
 * 
 * @package   Models
 * @author    Helmut Schottmüller <https://github.com/hschottm>
 * @copyright Helmut Schottmüller 2012
 */
class TagModel extends \Model
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
