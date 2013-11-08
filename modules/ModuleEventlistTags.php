<?php

/**
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 2.1 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at http://www.gnu.org/licenses/.
 *
 * PHP version 5
 * @copyright  Helmut Schottmüller 2009
 * @author     Helmut Schottmüller <typolight@aurealis.de>
 * @package    tags
 * @license    LGPL
 * @filesource
 */

namespace Contao;

if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Class ModuleEventlistTags
 *
 * Front end module "event list with tags support".
 * @copyright  Helmut Schottmüller 2009
 * @author     Helmut Schottmüller <typolight@aurealis.de>
 * @package    Controller
 */
class ModuleEventlistTags extends \ModuleEventlist
{
	/**
	 * Generate module
	 */
	protected function getAllEvents($arrCalendars, $intStart, $intEnd)
	{
		$arrAllEvents = parent::getAllEvents($arrCalendars, $intStart, $intEnd);
		if (($this->tag_ignore) && !strlen($this->tag_filter)) return $arrAllEvents;
	
		if (strlen(\Input::get('tag')) || strlen($this->tag_filter))
		{
			$limit = null;
			$offset = 0;
			$tagids = array();
			if (strlen($this->tag_filter)) $tagids = $this->getFilterTags();

			$relatedlist = (strlen(\Input::get('related'))) ? preg_split("/,/", \Input::get('related')) : array();
			$tagArray = (strlen(\Input::get('tag'))) ? array(\Input::get('tag')) : array();
			$alltags = array_merge($tagArray, $relatedlist);
			foreach ($alltags as $tag)
			{
				if (count($tagids))
				{
					$tagids = $this->Database->prepare("SELECT tid FROM tl_tag WHERE from_table = ? AND tag = ? AND tid IN (" . join($tagids, ",") . ")")
						->execute('tl_calendar_events', $tag)
						->fetchEach('tid');
				}
				else
				{
					$tagids = $this->Database->prepare("SELECT tid FROM tl_tag WHERE from_table = ? AND tag = ?")
						->execute('tl_calendar_events', $tag)
						->fetchEach('tid');
				}
			}
			if (count($tagids))
			{
				foreach ($arrAllEvents as $allEventsIdx => $days)
				{
					foreach ($days as $daysIdx => $day)
					{
						foreach ($day as $dayIdx => $event)
						{
							if (!in_array($event['id'], $tagids)) unset($arrAllEvents[$allEventsIdx][$daysIdx][$dayIdx]);
						}
					}
				}
			}
			else
			{
				$arrAllEvents = array();
			}
		}
		return $arrAllEvents;
	}
	
	/**
	 * Generate module
	 */
	protected function compile()
	{
		parent::compile();
		$headlinetags = array();
		if ((strlen(\Input::get('tag')) && (!$this->tag_ignore)) || (strlen($this->tag_filter)))
		{
			if (strlen($this->tag_filter))
			{
				$headlinetags = preg_split("/,/", $this->tag_filter);
				$tagids = $this->getFilterTags();
				$first = false;
			}
			else
			{
				$headlinetags = array();
			}
			$relatedlist = (strlen(\Input::get('related'))) ? preg_split("/,/", \Input::get('related')) : array();
			$tagArray = (strlen(\Input::get('tag'))) ? array(\Input::get('tag')) : array();
			$headlinetags = array_merge($headlinetags, $tagArray);
			if (count($relatedlist))
			{
				$headlinetags = array_merge($headlinetags, $relatedlist);
			}
		}
		if (strlen($this->Template->events) == 0)
		{
			$headlinetags = array_merge(array(\Input::get('tag')), $relatedlist);
			$this->Template->events = $GLOBALS['TL_LANG']['MSC']['emptyevents'];
		}
		$this->Template->tags_activetags = $headlinetags;
	}

	/**
	 * Read tags from database
	 * @return string
	 */
	protected function getFilterTags()
	{
		if (strlen($this->tag_filter))
		{
			$tags = preg_split("/,/", $this->tag_filter);
			$placeholders = array();
			foreach ($tags as $tag)
			{
				array_push($placeholders, '?');
			}
			array_push($tags, 'tl_calendar_events');
			return $this->Database->prepare("SELECT tid FROM tl_tag WHERE tag IN (" . join($placeholders, ',') . ") AND from_table = ? ORDER BY tag ASC")
				->execute($tags)
				->fetchEach('tid');
		}
		else
		{
			return array();
		}
	}
}

?>