<?php

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2011 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Helmut Schottmüller 2011
 * @author     Helmut Schottmüller <http://www.aurealis.de>
 * @package    Calendar
 * @license    LGPL
 * @filesource
 */

namespace Contao;

if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Class CalendarTags
 *
 * Provide methods regarding calendars.
 * @copyright  Helmut Schottmüller 2011
 * @author     Helmut Schottmüller <http://www.aurealis.de>
 * @package    Controller
 */
class CalendarTags extends \Calendar
{
	/**
	 * Add an event to the array of active events
	 * @param object
	 * @param integer
	 * @param integer
	 * @param string
	 * @param string
	 */
	protected function addEvent($objEvent, $intStart, $intEnd, $strUrl, $strLink)
	{
		parent::addEvent($objEvent, $intStart, $intEnd, $strUrl, $strLink);
		if ($GLOBALS['tags']['showInFeeds'])
		{
			if ($intStart < time())
			{
				return;
			}

			$intKey = date('Ymd', $intStart);
			$lastindex = count($this->arrEvents[$intKey][$intStart])-1;
			$tags = $this->getTagsForTableAndId('tl_calendar_events', $objEvent->id);
			if (strlen($tags))
			{
				$this->arrEvents[$intKey][$intStart][$lastindex]['description'] .= $tags;
			}
		}
	}

	private function getTagsForTableAndId($table, $id, $url = false)
	{
		$arrTags = $this->Database->prepare("SELECT * FROM tl_tag WHERE from_table = ? AND tid = ?")
			->execute($table, $id)
			->fetchAllAssoc();
		$res = false;
		$strUrl = '';
		if (count($arrTags))
		{
			if ($url)
			{
				switch ($table)
				{
					case 'tl_article':
						$objEvent = $this->Database->prepare("SELECT a.id AS aId, a.alias AS aAlias, a.title AS title, p.id AS id, p.alias AS alias FROM tl_article a, tl_page p WHERE a.pid=p.id AND (a.id=? OR a.alias=?)")
							->limit(1)
							->execute($id, $id);
						if ($objEvent->numRows < 1)
						{
							break;
						}
						else
						{
							$strUrl = $this->generateFrontendUrl($objEvent->row(), '/articles/' . ((!$GLOBALS['TL_CONFIG']['disableAlias'] && strlen($objEvent->aAlias)) ? $objEvent->aAlias : $objEvent->aId));
						}
						break;
				}
			}
			$objTemplate = new FrontendTemplate('tags_inserttag');
			$objTemplate->tags = $arrTags;
			$objTemplate->url = $strUrl;
			$res = $objTemplate->parse();
		}
		return $res;
	}
}

?>