<?php

namespace Hschottm\TagsBundle;

/**
 * Contao Open Source CMS - tags extension
 *
 * Copyright (c) 2008-2016 Helmut Schottmüller
 *
 * @license LGPL-3.0+
 */

class ModuleLastEventsTags extends \ModuleLastEvents
{

    /**
     * Get all events of a certain period
     *
     * @param array   $arrCalendars
     * @param integer $intStart
     * @param integer $intEnd
     * @param boolean $blnFeatured
     *
     * @return array
     */
    protected function getAllEvents($arrCalendars, $intStart, $intEnd, $blnFeatured = null)
	{
		$arrAllEvents = parent::getAllEvents($arrCalendars, $intStart, $intEnd);
		if (strlen(\TagHelper::decode(\Input::get('tag'))))
		{
			$limit = null;
			$offset = 0;
			$tagids = array();
			
			$relatedlist = (strlen(\TagHelper::decode(\Input::get('related')))) ? preg_split("/,/", \TagHelper::decode(\Input::get('related'))) : array();
			$alltags = array_merge(array(\TagHelper::decode(\Input::get('tag'))), $relatedlist);
			foreach ($alltags as $tag)
			{
				if (count($tagids))
				{
					$tagids = $this->Database->prepare("SELECT tid FROM tl_tag WHERE from_table = ? AND tag = ? AND tid IN (" . implode(",", $tagids) . ")")
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
		if (strlen(\TagHelper::decode(\Input::get('tag'))))
		{
			$relatedlist = (strlen(\TagHelper::decode(\Input::get('related')))) ? preg_split("/,/", \TagHelper::decode(\Input::get('related'))) : array();
			$this->Template->tags_activetags = array_merge(array(\TagHelper::decode(\Input::get('tag'))), $relatedlist);
		}
		if (strlen($this->Template->events) == 0)
		{
			$this->Template->tags_activetags = array_merge(array(\TagHelper::decode(\Input::get('tag'))), $relatedlist);
			$this->Template->events = $GLOBALS['TL_LANG']['MSC']['emptyevents'];
		}
	}
}

class_alias(ModuleLastEventsTags::class, 'ModuleLastEventsTags');
