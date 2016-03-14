<?php

namespace Contao;

/**
 * Contao Open Source CMS - tags extension
 *
 * Copyright (c) 2008-2016 Helmut Schottmüller
 *
 * @license LGPL-3.0+
 */

class ModuleCalendarTags extends \ModuleCalendar
{

	/**
	 * Get all events of a certain period
	 *
	 * @param array   $arrCalendars
	 * @param integer $intStart
	 * @param integer $intEnd
	 *
	 * @return array
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
							if (!in_array($event['id'], $tagids)) {
								unset($arrAllEvents[$allEventsIdx][$daysIdx][$dayIdx]);
								if (is_array($arrAllEvents[$allEventsIdx][$daysIdx]) && count($arrAllEvents[$allEventsIdx][$daysIdx]) == 0)
								{
									unset($arrAllEvents[$allEventsIdx][$daysIdx]);
								}
								if (is_array($arrAllEvents[$allEventsIdx]) && count($arrAllEvents[$allEventsIdx]) == 0)
								{
									unset($arrAllEvents[$allEventsIdx]);
								}
							}
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
	 * Return all weeks of the current month as array
	 *
	 * @return array
	 */
	protected function compileWeeks()
	{
		$arrDays = parent::compileWeeks();
		$helper = new \TagHelper();
		foreach ($arrDays as $strWeekClass => $week)
		{
			foreach ($week as $i => $event)
			{
				foreach ($event['events'] as $eventindex => $vv)
				{
					$tagsandlist = $helper->getTagsAndTaglistForIdAndTable($vv['id'], 'tl_calendar_events', $this->jumpTo);
					$vv['tags'] = $tagsandlist['tags'];
					$vv['taglist'] = $tagsandlist['taglist'];
					$arrDays[$strWeekClass][$i]['events'][$eventindex] = $vv;
				}
			}
		}
		return $arrDays;
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