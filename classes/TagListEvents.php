<?php

namespace Contao;

/**
 * Class TagListEvents
 *
 * Provide methods to handle tag input fields.
 * @copyright  Helmut Schottmüller 2009-2013
 * @author     Helmut Schottmüller <https://github.com/hschottm>
 * @package    Controller
 */
class TagListEvents extends TagList
{
	protected $arrCalendars = array();

  public function getRelatedTagList($for_tags, $blnExcludeUnpublishedItems = true)
	{
		if (!is_array($for_tags)) return array();
		if (!count($this->arrCalendars)) return array();

    if (TL_MODE == 'BE')
		{
			$blnExcludeUnpublishedItems = false;
		}

		$ids = array();
		for ($i = 0; $i < count($for_tags); $i++)
		{
			$arr = $this->Database->prepare("SELECT DISTINCT tl_tag.tid FROM tl_tag, tl_calendar_events WHERE tl_tag.tid = tl_calendar_events.id AND tl_calendar_events.pid IN ('" . join($this->arrCalendars, "','") . "') AND from_table = ? AND tag = ?" . (!BE_USER_LOGGED_IN ? " AND (start='' OR start<?) AND (stop='' OR stop>?) AND published=1" : "") . " ORDER BY tl_tag.tid ASC")
				->execute(array('tl_calendar_events', $for_tags[$i], time(), time()))
				->fetchEach('tid');
			if ($i == 0)
			{
				$ids = $arr;
			}
			else
			{
				$ids = array_intersect($ids, $arr);
			}
		}

		$arrCloudTags = array();
		if (count($ids))
		{
			$objTags = $this->Database->prepare("SELECT tag, COUNT(tag) as count FROM tl_tag, tl_calendar_events WHERE tl_tag.tid = tl_calendar_events.id AND tl_calendar_events.pid IN ('" . join($this->arrCalendars, "','") . "') AND from_table = ? AND tl_tag.tid IN (" . join($ids, ",") . ")" . (!BE_USER_LOGGED_IN ? " AND (start='' OR start<?) AND (stop='' OR stop>?) AND published=1" : "") . " GROUP BY tag ORDER BY tag ASC")
				->execute('tl_calendar_events', time(), time());
			$list = "";
			$tags = array();
			if ($objTags->numRows)
			{
				while ($objTags->next())
				{
					if (!in_array($objTags->tag, $for_tags))
					{
						$count = count($this->Database->prepare("SELECT tl_tag.tid FROM tl_tag, tl_calendar_events WHERE tl_tag.tid = tl_calendar_events.id AND tl_calendar_events.pid IN ('" . join($this->arrCalendars, "','") . "') AND tag = ? AND from_table = ?" . (!BE_USER_LOGGED_IN ? " AND (start='' OR start<?) AND (stop='' OR stop>?) AND published=1" : "") . " AND tl_tag.tid IN (" . join($ids, ",") . ")")
							->execute($objTags->tag, 'tl_calendar_events', time(), time())
							->fetchAllAssoc());
						array_push($tags, array('tag_name' => $objTags->tag, 'tag_count' => $count));
					}
				}
			}
			if (count($tags))
			{
				$arrCloudTags = $this->cloud_tags($tags);
			}
		}
		return $arrCloudTags;
	}

  public function getTagList($blnExcludeUnpublishedItems = true)
	{
		if (count($this->arrCloudTags) == 0)
		{
			if (count($this->arrCalendars))
			{
				$objTags = $this->Database->prepare("SELECT tag, COUNT(tag) as count FROM tl_tag, tl_calendar_events WHERE tl_tag.tid = tl_calendar_events.id AND tl_calendar_events.pid IN ('" . join($this->arrCalendars, "','") . "') AND from_table = ?" . (!BE_USER_LOGGED_IN ? " AND (start='' OR start<?) AND (stop='' OR stop>?) AND published=1" : "") . " GROUP BY tag ORDER BY tag ASC")
					->execute('tl_calendar_events', time(), time());
				$list = "";
				$tags = array();
				if ($objTags->numRows)
				{
					while ($objTags->next())
					{
						array_push($tags, array('tag_name' => $objTags->tag, 'tag_count' => $objTags->count));
					}
				}
				if (count($tags))
				{
					$this->arrCloudTags = $this->cloud_tags($tags);
				}
			}
		}
		return $this->arrCloudTags;
	}

	/**
	 * Add specific attributes
	 * @param string
	 * @param mixed
	 */
	public function __set($strKey, $varValue)
	{
		switch ($strKey)
		{
			case 'calendars':
				$this->arrCalendars = $varValue;
				break;
			default:
				parent::__set($strKey, $varValue);
				break;
		}
	}

	/**
	 * Return a parameter
	 * @return string
	 * @throws Exception
	 */
	public function __get($strKey)
	{
		switch ($strKey)
		{
			case 'calendars':
				return $this->arrCalendars;
				break;
			default:
				return parent::__get($strKey);
				break;
		}
	}
}
