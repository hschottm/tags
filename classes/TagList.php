<?php

/**
 * TYPOlight webCMS
 * Copyright (C) 2005 Leo Feyer
 *
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
 * @copyright  Helmut Schottmüller 2008
 * @author     Helmut Schottmüller <typolight@aurealis.de>
 * @package    Backend
 * @license    LGPL
 * @filesource
 */

namespace Contao;

if (!defined('TL_ROOT')) die('You can not access this file directly!');


/**
 * Class TagList
 *
 * Provide methods to handle tag input fields.
 * @copyright  Helmut Schottmüller 2008
 * @author     Helmut Schottmüller <typolight@aurealis.de>
 * @package    Controller
 */
class TagList extends \System
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
	
	function __construct($forTable = "") 
	{
		parent::__construct();
		$this->forTable = $forTable;
		$this->import('Database');
	}
	
	public function getRelatedTagList($for_tags)
	{
		if (!is_array($for_tags)) return array();

		$tagtable = (strlen($this->strTagTable)) ? $this->strTagTable : "tl_tag";
		$tagfield = (strlen($this->strTagField)) ? $this->strTagField : "tag";

		$ids = array();
		if (is_array($this->forTable))
		{
			$keys = array();
			$values = array();
			foreach ($this->forTable as $table)
			{
				array_push($keys, 'from_table = ?');
				array_push($values, $table);
			}
			$ids = array();
			for ($i = 0; $i < count($for_tags); $i++)
			{
				$arr = $this->Database->prepare("SELECT DISTINCT tid FROM $tagtable WHERE (" . join($keys, " OR ") . ") AND $tagfield = ? ORDER BY id ASC")
					->execute(array_merge($values, array($for_tags[$i])))
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
			if (strlen($this->forTable))
			{
				$ids = array();
				for ($i = 0; $i < count($for_tags); $i++)
				{
					$arr = $this->Database->prepare("SELECT DISTINCT tid FROM $tagtable WHERE from_table = ? AND $tagfield = ? ORDER BY id ASC")
						->execute(array($this->forTable, $for_tags[$i]))
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
				for ($i = 0; $i < count($for_tags); $i++)
				{
					$arr = $this->Database->prepare("SELECT DISTINCT tid FROM $tagtable WHERE $tagfield = ? ORDER BY id ASC")
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
					array_push($keys, 'from_table = ?');
				}
				$objTags = $this->Database->prepare("SELECT $tagfield, COUNT($tagfield) as count FROM $tagtable WHERE (" . join($keys, " OR ") . ") AND tid IN (" . join($ids, ",") . ") GROUP BY $tagfield ORDER BY $tagfield ASC")
					->execute($this->forTable);
			}
			else
			{
				if (strlen($this->forTable))
				{
					$objTags = $this->Database->prepare("SELECT $tagfield, COUNT($tagfield) as count FROM $tagtable WHERE from_table = ? AND tid IN (" . join($ids, ",") . ") GROUP BY $tagfield ORDER BY $tagfield ASC")
						->execute($this->forTable);
				}
				else
				{
					$objTags = $this->Database->prepare("SELECT $tagfield, COUNT($tagfield) as count FROM $tagtable WHERE tid IN (" . join($ids, ",") . ") GROUP BY $tagfield ORDER BY $tagfield ASC")
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
								array_push($keys, 'from_table = ?');
							}
							$count = count($this->Database->prepare("SELECT tid FROM $tagtable WHERE $tagfield = ? AND (" . join($keys, " OR ") . ") AND tid IN (" . join($ids, ",") . ")")
								->execute(array_merge(array($objTags->tag), $this->forTable))
								->fetchAllAssoc());
						}
						else
						{
							if (strlen($this->forTable))
							{
								$count = count($this->Database->prepare("SELECT tid FROM $tagtable WHERE $tagfield = ? AND from_table = ? AND tid IN (" . join($ids, ",") . ")")
									->execute($objTags->tag, $this->forTable)
									->fetchAllAssoc());
							}
							else
							{
								$count = count($this->Database->prepare("SELECT $tagfield, COUNT($tagfield) as count FROM $tagtable WHERE $tagfield = ? AND tid IN (" . join($ids, ",") . ")")
									->execute($objTags->tag)
									->fetchAllAssoc());
							}
						}
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

	public function getTagList()
	{
		if (count($this->arrCloudTags) == 0)
		{
			$tagtable = (strlen($this->strTagTable)) ? $this->strTagTable : "tl_tag";
			$tagfield = (strlen($this->strTagField)) ? $this->strTagField : "tag";
			if (is_array($this->forTable))
			{
				$keys = array();
				$values = array();
				for ($i = 0; $i < count($this->forTable); $i++)
				{
					array_push($keys, 'from_table = ?');
				}
				$objTags = $this->Database->prepare("SELECT $tagfield, COUNT($tagfield) as count FROM $tagtable WHERE (" . join($keys, " OR ") . ") GROUP BY $tagfield ORDER BY $tagfield ASC")
					->execute($this->forTable);
			}
			else
			{
				if (strlen($this->forTable))
				{
					$objTags = $this->Database->prepare("SELECT $tagfield, COUNT($tagfield) as count FROM $tagtable WHERE from_table = ? GROUP BY $tagfield ORDER BY $tagfield ASC")
						->execute($this->forTable);
				}
				else
				{
					$objTags = $this->Database->prepare("SELECT $tagfield, COUNT($tagfield) as count FROM $tagtable GROUP BY $tagfield ORDER BY $tagfield ASC")
						->execute();
				}
			}
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
		return $this->arrCloudTags;
	}
	
	public function getTopTenTagList()
	{
		$list = $this->getTagList();
		usort($list, array($this, "tag_asort"));
		if (count($list) > 10) $list = array_reverse(array_slice($list, -10, 10));
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
		return str_replace('"', '', str_replace(' ', '_', $tag));
	}

	public static function _getTagNameClass($tag)
	{
		return str_replace('"', '', str_replace(' ', '_', $tag));
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

	protected function getArticlesForPages()
	{
		$this->arrArticles = array();
		if (count($this->arrPages))
		{
			$time = time();

			// Get published articles
			$pids = join($this->arrPages, ",");
			if (strlen($this->inColumn))
			{
				$objArticles = $this->Database->prepare("SELECT id, title, alias, inColumn, cssID FROM tl_article WHERE inColumn = ? AND pid IN (" . $pids . ") " . (!BE_USER_LOGGED_IN ? " AND (start='' OR start<?) AND (stop='' OR stop>?) AND published=1" : "") . " ORDER BY sorting")
											  ->execute($this->inColumn, $time, $time);
			}
			else
			{
				$objArticles = $this->Database->prepare("SELECT id, title, alias, inColumn, cssID FROM tl_article WHERE pid IN (" . $pids . ") " . (!BE_USER_LOGGED_IN ? " AND (start='' OR start<?) AND (stop='' OR stop>?) AND published=1" : "") . " ORDER BY sorting")
											  ->execute($time, $time);
			}
			if ($objArticles->numRows < 1)
			{
				return;
			}

			while ($objArticles->next())
			{
				// Skip first article
				if (++$intCount == 1 && $this->skipFirst)
				{
					continue;
				}

				$cssID = deserialize($objArticles->cssID, true);
				$alias = strlen($objArticles->alias) ? $objArticles->alias : $objArticles->title;

				array_push($this->arrArticles, $objArticles->id);
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
				array_push($this->arrPages, $varValue[0]);
				$this->getRelevantPages($varValue[0]);
				$this->getArticlesForPages();
				break;
			case 'fortable':
				$this->forTable = $varValue;
				break;
			case 'tagtable':
				$this->strTagTable = ($this->Database->tableExists($varValue)) ? $varValue : 'tl_tag';
				break;
			case 'tagfield':
				$this->strTagField = ($this->Database->fieldExists($varValue, $this->tagtable)) ? $varValue : 'tag';
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

?>