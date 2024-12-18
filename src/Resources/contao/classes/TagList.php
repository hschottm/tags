<?php

namespace Hschottm\TagsBundle;

/**
 * Contao Open Source CMS - tags extension
 *
 * Copyright (c) 2008-2024 Helmut Schottmüller
 *
 * @license LGPL-3.0+
 */

use Contao\System;
use Contao\Database;
use Contao\StringUtil;

class TagList extends System
{
	protected $forTable = "";
	protected $strTagTable = "tl_tag";
	protected $strTagField = "tag";
	protected $intBuckets = 4;
	protected $intMaxTags = 0;
	protected $arrCloudTags = array();
	protected $boolNamedClass = false;
	protected $arrPages = array();
	protected $arrArticles = array();
	protected $intTopNumber = 10;

	function __construct($forTable = "")
	{
		parent::__construct();
		$this->forTable = $forTable;
	}

	public function getRelatedTagList($for_tags, $blnExcludeUnpublishedItems = true)
	{
		if (!is_array($for_tags)) return array();

		$tagtable = (strlen($this->strTagTable)) ? $this->strTagTable : "tl_tag";
		$tagfield = (strlen($this->strTagField)) ? $this->strTagField : "tag";

		$request = System::getContainer()->get('request_stack')->getCurrentRequest();
		if ($request && System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest($request))
		{
			$blnExcludeUnpublishedItems = false;
		}

		$ids = array();
		if (is_array($this->forTable))
		{
			$arrForTable = $this->forTable;
		}
		elseif (strlen($this->forTable))
		{
			$arrForTable = (array) $this->forTable;
		}

		if (is_array($arrForTable))
		{
			$arrTableSql = array();
			foreach ($arrForTable as $strTable)
			{
				if ($blnExcludeUnpublishedItems && Database::getInstance()->fieldExists('published', $strTable))
				{
					$arrTableSql[] = "SELECT DISTINCT tid FROM $tagtable, $strTable WHERE (from_table='$strTable' AND tid=$strTable.id AND published='1') AND $tagfield = '?'";
				}
				else
				{
					$arrTableSql[] = "SELECT DISTINCT tid FROM $tagtable WHERE from_table='$strTable' AND $tagfield = '?'";
				}
			}

			$ids = array();
			for ($i = 0; $i < count($for_tags); $i++)
			{
				$arrSql = array();
				foreach ($arrTableSql as $sql)
				{
					$arrSql[] = str_replace("?", $for_tags[$i], $sql);
				}
				$arr = Database::getInstance()->prepare(implode(" UNION ", $arrSql))
					->execute()
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
		}
		else
		{
			$ids = array();

			$strCondPublished = '';
			if ($blnExcludeUnpublishedItems && Database::getInstance()->fieldExists('published', $tagtable))
			{
				$strCondPublished = " AND published='1'";
			}

			for ($i = 0; $i < count($for_tags); $i++)
			{
				$arr = Database::getInstance()->prepare("SELECT DISTINCT tid FROM $tagtable WHERE $tagfield = ? $strCondPublished")
					->execute($for_tags[$i])
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
		}

		$arrCloudTags = array();
		if (count($ids))
		{
			if (is_array($this->forTable))
			{
				$keys = array();
				$values = array();
				for ($i = 0; $i < count($this->forTable); $i++)
				{
					\array_push($keys, "from_table = '" . $this->forTable[$i] . "'");
				}
				$objTags = Database::getInstance()->prepare("SELECT $tagfield, COUNT($tagfield) as count FROM $tagtable WHERE (" . implode(" OR ", $keys) . ") AND tid IN (" . implode(",", $ids) . ") GROUP BY $tagfield ORDER BY $tagfield ASC")
					->execute();
			}
			else
			{
				if (strlen($this->forTable))
				{
					$objTags = Database::getInstance()->prepare("SELECT $tagfield, COUNT($tagfield) as count FROM $tagtable WHERE from_table = ? AND tid IN (" . implode(",", $ids) . ") GROUP BY $tagfield ORDER BY $tagfield ASC")
						->execute($this->forTable);
				}
				else
				{
					$objTags = Database::getInstance()->prepare("SELECT $tagfield, COUNT($tagfield) as count FROM $tagtable WHERE tid IN (" . implode(",", $ids) . ") GROUP BY $tagfield ORDER BY $tagfield ASC")
						->execute();
				}
			}
			$list = "";
			$tags = array();
			if ($objTags->numRows)
			{
				while ($objTags->next())
				{
					if (!in_array($objTags->tag, $for_tags))
					{
						$count = 0;
						if (is_array($this->forTable))
						{
							$keys = array();
							$values = array();
							for ($i = 0; $i < count($this->forTable); $i++)
							{
								\array_push($keys, "from_table = '" . $this->forTable[$i] . "'");
							}
							$count = count(Database::getInstance()->prepare("SELECT tid FROM $tagtable WHERE $tagfield = ? AND (" . implode(" OR ", $keys) . ") AND tid IN (" . implode(",", $ids) . ")")
								->execute($objTags->tag)
								->fetchAllAssoc());
						}
						else
						{
							if (strlen($this->forTable))
							{
								$count = count(Database::getInstance()->prepare("SELECT tid FROM $tagtable WHERE $tagfield = ? AND from_table = ? AND tid IN (" . implode(",", $ids) . ")")
									->execute($objTags->tag, $this->forTable)
									->fetchAllAssoc());
							}
							else
							{
								$count = count(Database::getInstance()->prepare("SELECT $tagfield, COUNT($tagfield) as count FROM $tagtable WHERE $tagfield = ? AND tid IN (" . implode(",", $ids) . ")")
									->execute($objTags->tag)
									->fetchAllAssoc());
							}
						}
						\array_push($tags, array('tag_name' => $objTags->tag, 'tag_count' => $count));
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
			$tagtable = (strlen($this->strTagTable)) ? $this->strTagTable : "tl_tag";
			$tagfield = (strlen($this->strTagField)) ? $this->strTagField : "tag";

			$request = System::getContainer()->get('request_stack')->getCurrentRequest();
			if ($request && System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest($request))
				{
				$blnExcludeUnpublishedItems = false;
			}

			$sql = '';
			$arrSql = array();

			if (is_array($this->forTable))
			{
				$arrForTable = $this->forTable;
			}
			elseif (strlen($this->forTable))
			{
				$arrForTable = (array) $this->forTable;
			}

			if (is_array($arrForTable))
			{
				foreach ($arrForTable as $strTable)
				{
					if ($blnExcludeUnpublishedItems && Database::getInstance()->fieldExists('published', $strTable))
					{
						$arrSql[] = "SELECT $tagfield, COUNT($tagfield) AS count FROM $tagtable, $strTable WHERE (from_table='$strTable' AND tid=$strTable.id AND published='1') GROUP BY $tagfield";
					}
					else
					{
						$arrSql[] = "SELECT $tagfield, COUNT($tagfield) AS count FROM $tagtable	WHERE from_table='$strTable' GROUP BY $tagfield";
					}
				}
				if (count($arrSql) > 1)
				{
					$sql = "SELECT $tagfield AS tag, SUM(count) AS count FROM (" . implode(" UNION ", $arrSql). ") temp GROUP BY tag";
				}
				else
				{
					$sql = $arrSql[0];
				}
			}
			else
			{
				$strCondPublished = '';
				if ($blnExcludeUnpublishedItems && Database::getInstance()->fieldExists('published', $tagtable))
				{
					$strCondPublished = "WHERE published='1'";
				}

				$sql = "SELECT $tagfield, COUNT($tagfield) as count FROM $tagtable $strCondPublished GROUP BY $tagfield ORDER BY $tagfield ASC";
			}

			$objTags = Database::getInstance()->prepare($sql)->execute();

			$list = "";
			$tags = array();
			if ($objTags->numRows)
			{
				while ($objTags->next())
				{
					\array_push($tags, array('tag_name' => $objTags->tag, 'tag_count' => $objTags->count));
				}
			}
			if (count($tags))
			{
				$this->arrCloudTags = $this->cloud_tags($tags);
			}
		}
		return $this->arrCloudTags;
	}

	public function getTopTenTagList()
	{
		$list = $this->getTagList();
		usort($list, array($this, "tag_asort"));
		if (count($list) > $this->intTopNumber) $list = array_reverse(array_slice($list, -$this->intTopNumber, $this->intTopNumber));
		return $list;
	}

	protected function cloud_tags($tags)
	{
		usort($tags, array($this, "tag_asort"));
		if ($this->intMaxTags > 0)
		{
			if (count($tags) > $this->intMaxTags)
			{
				$tags = array_slice($tags, -$this->intMaxTags, $this->intMaxTags);
			}
		}
		if(count($tags) > 0)
		{
			// Start with the sorted list of tags and divide by the number of font sizes (buckets).
			// Then proceed to put an even number of tags into each bucket.  The only restriction is
			// that tags of the same count can't span 2 buckets, so some buckets may have more tags
			// than others.  Because of this, the sorted list of remaining tags is divided by the
			// remaining 'buckets' to evenly distribute the remainder of the tags and to fill as
			// many 'buckets' as possible up to the largest font size.

			$total_tags = count($tags);
			$min_tags = $total_tags / $this->intBuckets;
			$bucket_count = 1;
			$bucket_items = 0;
			$tags_set = 0;
			foreach($tags as $key => $tag)
			{
				$tag_count = $tag['tag_count'];

				// If we've met the minimum number of tags for this class and the current tag
				// does not equal the last tag, we can proceed to the next class.

				if(($bucket_items >= $min_tags) and $last_count != $tag_count and $bucket_count < $this->intBuckets)
				{
					$bucket_count++;
					$bucket_items = 0;

					// Calculate a new minimum number of tags for the remaining classes.

					$remaining_tags = $total_tags - $tags_set;
					$min_tags = $remaining_tags / $bucket_count;
				}

				// Set the tag to the current class.
				$tags[$key]['tag_class'] = 'size'.$bucket_count . (($this->boolNamedClass) ? (' ' . $this->getTagNameClass($tag['tag_name'])) : '');
				$bucket_items++;
				$tags_set++;

				$last_count = $tag_count;
			}
			usort($tags, array($this, 'tag_alphasort'));
		}

		return $tags;
	}

	/**
	 * Generate a class name from a tag name
	 * @param string
	 * @return string
	 */
	protected function getTagNameClass($tag)
	{
		return StringUtil::convertEncoding(StringUtil::standardize($tag), "ASCII");
	}

	public static function _getTagNameClass($tag)
	{
		return StringUtil::convertEncoding(StringUtil::standardize($tag), "ASCII");
	}

	protected function getRelevantPages($page_id)
	{
		$objPageWithId = Database::getInstance()->prepare("SELECT id, published, start, stop FROM tl_page WHERE pid=? ORDER BY sorting")
			->execute($page_id);
		while ($objPageWithId->next())
		{
			if ($objPageWithId->published && (strlen($objPageWithId->start) == 0 || $objPageWithId->start < time()) && (strlen($objPageWithId->end) == 0 || $objPageWithId->end > time()))
			{
				\array_push($this->arrPages, $objPageWithId->id);
			}
			$this->getRelevantPages($objPageWithId->id);
		}
	}

	protected function getArticlesForPages()
	{
		$this->arrArticles = array();
		if (count($this->arrPages))
		{
			$time = time();

			$hasBackendUser = System::getContainer()->get('contao.security.token_checker')->hasBackendUser();
			$showUnpublished = System::getContainer()->get('contao.security.token_checker')->isPreviewMode();
			$hasFrontendUser = System::getContainer()->get('contao.security.token_checker')->hasFrontendUser();
			
			// Get published articles
			$pids = implode(",", $this->arrPages);
			if (strlen($this->inColumn))
			{
				if (!$hasBackendUser) {
					$objArticles = Database::getInstance()->prepare("SELECT id, title, alias, inColumn, cssID FROM tl_article WHERE inColumn = ? AND pid IN (" . $pids . ") " . " AND (start='' OR start<?) AND (stop='' OR stop>?) AND published=1" . " ORDER BY sorting")
						->execute($this->inColumn, $time, $time);
				} else {
					$objArticles = Database::getInstance()->prepare("SELECT id, title, alias, inColumn, cssID FROM tl_article WHERE inColumn = ? AND pid IN (" . $pids . ") " . " ORDER BY sorting")
						->execute($this->inColumn);
				}
			}
			else
			{
				if (!$hasBackendUser) {
					$objArticles = Database::getInstance()->prepare("SELECT id, title, alias, inColumn, cssID FROM tl_article WHERE pid IN (" . $pids . ") " . " AND (start='' OR start<?) AND (stop='' OR stop>?) AND published=1" . " ORDER BY sorting")
					->execute($time, $time);
				} else {
					$objArticles = Database::getInstance()->prepare("SELECT id, title, alias, inColumn, cssID FROM tl_article WHERE pid IN (" . $pids . ") " . " ORDER BY sorting")
					->execute();
				}
			}
			if ($objArticles->numRows < 1)
			{
				return;
			}

			$intCount = 0;
			while ($objArticles->next())
			{
				// Skip first article
				if (++$intCount == 1 && $this->skipFirst)
				{
					continue;
				}

				$cssID = StringUtil::deserialize($objArticles->cssID, true);
				$alias = strlen($objArticles->alias) ? $objArticles->alias : $objArticles->title;

				\array_push($this->arrArticles, $objArticles->id);
			}
		}
	}

	/****************************************************************************************/
	// Sorts a list of tags by their count ascending.

	function tag_asort($tag1, $tag2)
	{
	   if($tag1['tag_count'] == $tag2['tag_count'])
	   {
	       return 0;
	   }
	   return ($tag1['tag_count'] < $tag2['tag_count']) ? -1 : 1;
	}

	/****************************************************************************************/
	// Sorts a list of tags alphabetically by tag_name

	function tag_alphasort($tag1, $tag2)
	{
		return strnatcasecmp($tag1['tag_name'], $tag2['tag_name']);
	}

	/****************************************************************************************/

	/**
	 * Add specific attributes
	 * @param string
	 * @param mixed
	 */
	public function __set($strKey, $varValue)
	{
		switch ($strKey)
		{
			case 'pagesource':
				\array_push($this->arrPages, $varValue[0]);
				$this->getRelevantPages($varValue[0]);
				$this->getArticlesForPages();
				break;
			case 'fortable':
				$this->forTable = $varValue;
				break;
			case 'topnumber':
				$this->intTopNumber = $varValue;
				break;
			case 'tagtable':
				$this->strTagTable = (Database::getInstance()->tableExists($varValue)) ? $varValue : 'tl_tag';
				break;
			case 'tagfield':
				$this->strTagField = (Database::getInstance()->fieldExists($varValue, $this->tagtable)) ? $varValue : 'tag';
				break;
			case 'maxtags':
				$this->intMaxTags = $varValue;
				break;
			case 'buckets':
				$this->intBuckets = $varValue;
				break;
			case 'addNamedClass':
				$this->boolNamedClass = $varValue;
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
			case 'fortable':
				return $this->forTable;
				break;
			case 'tagtable':
				return $this->strTagTable;
				break;
			case 'tagfield':
				return $this->strTagField;
				break;
			case 'maxtags':
				return $this->intMaxTags;
				break;
			case 'topnumber':
				return $this->intTopNumber;
				break;
			case 'buckets':
				return $this->intBuckets;
				break;
			case 'addNamedClass':
				return $this->boolNamedClass;
				break;
			default:
				return parent::__get($strKey);
				break;
		}
	}
}
