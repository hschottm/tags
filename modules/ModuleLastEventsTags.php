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
 * Class ModuleLastEventsTags
 *
 * Front end module "last events with tags support".
 * @copyright  Helmut Schottmüller 2009
 * @author     Helmut Schottmüller <typolight@aurealis.de>
 * @package    Controller
 */
class ModuleLastEventsTags extends \ModuleLastEvents
{
	/**
	 * Generate module
	 */
	protected function getAllEvents($arrCalendars, $intStart, $intEnd)
	{
		$arrAllEvents = parent::getAllEvents($arrCalendars, $intStart, $intEnd);
		if (strlen(\Input::get('tag')))
		{
			$limit = null;
			$offset = 0;
			$tagids = array();
			
			$relatedlist = (strlen(\Input::get('related'))) ? preg_split("/,/", \Input::get('related')) : array();
			$alltags = array_merge(array(\Input::get('tag')), $relatedlist);
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
		if (strlen(\Input::get('tag')))
		{
			$relatedlist = (strlen(\Input::get('related'))) ? preg_split("/,/", \Input::get('related')) : array();
			$this->Template->tags_activetags = array_merge(array(\Input::get('tag')), $relatedlist);
		}
		if (strlen($this->Template->events) == 0)
		{
			$this->Template->tags_activetags = array_merge(array(\Input::get('tag')), $relatedlist);
			$this->Template->events = $GLOBALS['TL_LANG']['MSC']['emptyevents'];
		}
	}
}

?>