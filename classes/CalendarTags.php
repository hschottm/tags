<?php

namespace Contao;

/**
 * Contao Open Source CMS - tags extension
 *
 * Copyright (c) 2009-2016 Helmut Schottmüller
 *
 * @license LGPL-3.0+
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
  protected function addEvent($objEvent, $intStart, $intEnd, $strUrl, $strBase='')
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
