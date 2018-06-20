<?php

namespace Contao;

/**
 * Class TagListContentElements
 *
 * Provide methods to handle tag input fields.
 * @copyright  Helmut Schottmüller 2010-2013
 * @author     Helmut Schottmüller <https://github.com/hschottm>
 * @package    Controller
 */
class TagListContentElements extends TagList
{
	protected $arrContentElements = array();
	protected $arrPages = array();
	protected $inColumn = "";

  public function getRelatedTagList($for_tags, $blnExcludeUnpublishedItems = true)
	{
		if (!is_array($for_tags)) return array();
		if (!count($this->arrContentElements)) return array();

    if (TL_MODE == 'BE')
		{
			$blnExcludeUnpublishedItems = false;
		}

		$ids = array();
		for ($i = 0; $i < count($for_tags); $i++)
		{
			$arr = $this->Database->prepare("SELECT DISTINCT tl_tag.tid FROM tl_tag, tl_content WHERE tl_tag.tid = tl_content.id AND from_table = ?  AND tl_tag.tid IN (" . join($this->arrContentElements, ',') . ") AND tag = ?" . (!BE_USER_LOGGED_IN ? " AND (start='' OR start<?) AND (stop='' OR stop>?) AND invisible<>1" : "") . " ORDER BY tl_tag.tid ASC")
				->execute(array('tl_content', $for_tags[$i], time(), time()))
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
			$objTags = $this->Database->prepare("SELECT tag, COUNT(tag) as count FROM tl_tag, tl_content WHERE tl_tag.tid = tl_content.id AND from_table = ?" . (!BE_USER_LOGGED_IN ? " AND (start='' OR start<?) AND (stop='' OR stop>?) AND invisible<>1" : "") . " AND tl_tag.tid IN (" . join($ids, ",") . ") GROUP BY tag ORDER BY tag ASC")
				->execute('tl_content', time(), time());
			$list = "";
			$tags = array();
			if ($objTags->numRows)
			{
				while ($objTags->next())
				{
					if (!in_array($objTags->tag, $for_tags))
					{
						$count = count($this->Database->prepare("SELECT tl_tag.tid FROM tl_tag, tl_content WHERE tl_tag.tid = tl_content.id AND tag = ?" . (!BE_USER_LOGGED_IN ? " AND (start='' OR start<?) AND (stop='' OR stop>?) AND invisible<>1" : "") . " AND from_table = ? AND tl_tag.tid IN (" . join($ids, ",") . ")")
							->execute($objTags->tag, 'tl_content', time(), time())
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
			if (count($this->arrContentElements))
			{
				$objTags = $this->Database->prepare("SELECT tag, COUNT(tag) as count FROM tl_tag, tl_content WHERE tl_tag.tid = tl_content.id AND from_table = ?" . (!BE_USER_LOGGED_IN ? " AND (start='' OR start<?) AND (stop='' OR stop>?) AND invisible<>1" : "") . " AND tl_tag.tid IN (" . join($this->arrContentElements, ',') . ") GROUP BY tag ORDER BY tag ASC")
					->execute('tl_content', time(), time());
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

	protected function getRelevantPages($page_id)
	{
		$objPageWithId = $this->Database->prepare("SELECT id, published, start, stop FROM tl_page WHERE pid=? ORDER BY sorting")
			->execute($page_id);
		while ($objPageWithId->next())
		{
			if ($objPageWithId->published && (strlen($objPageWithId->start) == 0 || $objPageWithId->start < time()) && (strlen($objPageWithId->end) == 0 || $objPageWithId->end > time()))
			{
				array_push($this->arrPages, $objPageWithId->id);
			}
			$this->getRelevantPages($objPageWithId->id);
		}
	}

	protected function getContentElementsForPages()
	{
		$this->arrContentElements = array();
		if (count($this->arrPages))
		{
			$time = time();
			$arrArticles = $this->Database->prepare("SELECT id FROM tl_article WHERE pid IN (" . join($this->arrPages, ',') . ") " . (!BE_USER_LOGGED_IN ? " AND (start='' OR start<?) AND (stop='' OR stop>?) AND published=1" : "") . " ORDER BY sorting")
				->execute($time, $time)->fetchEach('id');
			$this->arrContentElements = $this->Database->prepare("SELECT id FROM tl_content WHERE pid IN (" . join($arrArticles, ',') . ") " . (!BE_USER_LOGGED_IN ? " AND invisible<>1" : "") . " ORDER BY sorting")
				->execute()->fetchEach('id');
		}
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
			case 'content_pages':
				// find all articles in this page and all subpages
				$this->getRelevantPages($varValue[0]);
				$this->getContentElementsForPages();
				break;
			case 'inColumn':
				$this->inColumn = $varValue;
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
			case 'content_pages':
				return $this->arrContentElements;
				break;
			case 'inColumn':
				return $this->inColumn;
			default:
				return parent::__get($strKey);
				break;
		}
	}
}
