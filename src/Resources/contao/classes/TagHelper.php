<?php

namespace Hschottm\TagsBundle;

use Contao\Backend;
use Contao\Module;
use Contao\Input;
use Contao\Database;
use Contao\PageModel;
use Contao\StringUtil;

/**
 * Contao Open Source CMS - tags extension
 *
 * Copyright (c) 2008-2024 Helmut Schottmüller
 *
 * @license LGPL-3.0+
 */

 class TagHelper extends Backend
{
    public static $config = array();
	
	/**
	 * Load the database object
	 */
	public function __construct()
	{
		parent::__construct();
	}

	public static function getPageObj($jumpTo = null)
	{
		global $objPage;
		if(!empty($jumpTo)) 
		{
			return (new PageModel())->findPublishedById($jumpTo);
		}
		else
		{
			return $objPage;
		}
	}

	public static function encode($tag)
	{
		return str_replace('/', 'x2F', $tag);
	}

	public static function decode($tag)
	{
		return str_replace('x2F', '/', $tag);
	}

	public function getAllEvents($arrEvents, $arrCalendars, $intStart, $intEnd, $caller)
	{
		return $arrEvents;
	}

	/*
	* Cleanup all tags that are associated to no longer existing TYPOlight objects
	*/
	public function deleteUnusedTags()
	{
		// fetch all tables
		$arrTables = Database::getInstance()->prepare("SELECT DISTINCT tl_tag.from_table FROM tl_tag")
			->execute()
			->fetchEach('from_table');
		foreach ($arrTables as $table)
		{
			$ids = Database::getInstance()->prepare("select DISTINCT tl_tag.tid from tl_tag left join " . $table . " on tl_tag.tid = " . $table . ".id where tl_tag.from_table = ? and " . $table . ".id is null")
				->execute($table)
				->fetchEach('tid');
			foreach ($ids as $id)
			{
				Database::getInstance()->prepare("DELETE FROM tl_tag WHERE tid = ? AND from_table = ?")
					->execute($id, $table);
			}
		}
	}
	
	public static function getSavedURLParams($objInput)
	{
		$strParams = '';
		$arrParams = array();
		if (strlen($objInput->get('year')))
		{
			array_push($arrParams, 'year=' . $objInput->get('year'));
		}
		if (strlen($objInput->get('month')))
		{
			array_push($arrParams, 'month=' . $objInput->get('month'));
		}
		if (strlen($objInput->get('day')))
		{
			array_push($arrParams, 'day=' . $objInput->get('day'));
		}
		if (count($arrParams))
		{
			$strParams = implode('&', $arrParams);
		}
		return $strParams;
	}
	
	public static function tagsForIdAndTable($id, $table) {
		return Database::getInstance()->prepare("SELECT tag FROM tl_tag WHERE tid = ? AND from_table = ? ORDER BY tag ASC")
			->execute($id, $table)
			->fetchEach('tag');
	}

	/**
	 * Read tags from database
	 * @return string
	 */
	protected function getTags($id, $table)
	{
		return Database::getInstance()->prepare("SELECT tag FROM tl_tag WHERE tid = ? AND from_table = ? ORDER BY tag ASC")
			->execute($id, $table)
			->fetchEach('tag');
	}

	public static function sortTagsByRelevance($a, $b)
	{
		if ($a['tagcount'] == $b['tagcount']) 
		{
			return 0;
		}
		return ($a['tagcount'] < $b['tagcount']) ? 1 : -1;
	} 

	public static function tagsForTableAndId($table, $id, $url = false, $max_tags = 0, $relevance = 0, $target = 0)
	{
		global $objPage;
		$arrTags = Database::getInstance()->prepare("SELECT * FROM tl_tag WHERE from_table = ? AND tid = ? ORDER BY tag ASC")
			->execute($table, $id)
			->fetchAllAssoc();
		$res = false;
		if (count($arrTags))
		{
			$arrTagsWithCount = Database::getInstance()->prepare("SELECT tag, COUNT(tag) as tagcount FROM tl_tag WHERE from_table = ? GROUP BY tag ORDER BY tag ASC")
				->execute($table)
				->fetchAllAssoc();
			$countarray = array();
			foreach ($arrTagsWithCount as $data)
			{
				$countarray[$data['tag']] = $data['tagcount'];
			}
			foreach ($arrTags as $idx => $tag)
			{
				$arrTags[$idx]['tagcount'] = $countarray[$tag['tag']];
			}
			if ($relevance == 1)
			{
				usort($arrTags, array(TagHelper::class, 'sortTagsByRelevance'));
			}
			if ($max_tags > 0)
			{
				$arrTags = array_slice($arrTags,0,$max_tags);
			}
			if (strlen($target))
			{
				$pageModel = new PageModel();
				$pageModel = $pageModel::findPublishedByIdOrAlias($target);
				if (!empty($pageModel))
				{
					foreach ($arrTags as $idx => $tag)
					{
						$arrTags[$idx]['url'] = \Contao\StringUtil::ampersand($pageModel->current()->getFrontendUrl('/tag/' . $tag['tag']));
					}
				}
			}
			if ($url)
			{
				switch ($table)
				{
					case 'tl_article':
						$objArticle = Database::getInstance()->prepare("SELECT a.id AS aId, a.alias AS aAlias, a.title AS title, p.id AS id, p.alias AS alias FROM tl_article a, tl_page p WHERE a.pid=p.id AND (a.id=? OR a.alias=?)")
							->limit(1)
							->execute($id, $id);
						if ($objArticle->numRows < 1)
						{
							break;
						}
						else
						{
							$pageObj = TagHelper::getPageObj($objArticle->tags_jumpto);
							foreach ($arrTags as $idx => $tag)
							{
								$arrTags[$idx]['url'] = $pageObj->getFrontendUrl('/articles/' . ((!$GLOBALS['TL_CONFIG']['disableAlias'] && strlen($objArticle->aAlias)) ? $objArticle->aAlias : $objArticle->aId));
							}
							// Whats up here?
							$objTemplate->url = $pageObj->getFrontendUrl('/articles/' . ((!$GLOBALS['TL_CONFIG']['disableAlias'] && strlen($objArticle->aAlias)) ? $objArticle->aAlias : $objArticle->aId));
						}
						break;
				}
			}
			$objTemplate = new FrontendTemplate('tags_inserttag');
			$objTemplate->tags = $arrTags;
			$res = $objTemplate->parse();
		}
		return $res;
	}
	
	public static function tagsForArticle(Module $moduleArticle, $max_tags = 0, $relevance = 0, $target = 0)
	{
		global $objPage;

		$table = 'tl_article';
		$id = $moduleArticle->id;
		$arrTags = Database::getInstance()->prepare("SELECT * FROM tl_tag WHERE from_table = ? AND tid = ? ORDER BY tag ASC")
			->execute($table, $id)
			->fetchAllAssoc();
		$res = false;
		if (count($arrTags))
		{
			if ($max_tags > 0)
			{
				$arrTags = array_slice($arrTags,0,$max_tags);
			}
			$arrTagsWithCount = Database::getInstance()->prepare("SELECT tag, COUNT(tag) as tagcount FROM tl_tag WHERE from_table = ? GROUP BY tag ORDER BY tag ASC")
				->execute($table)
				->fetchAllAssoc();
			$countarray = array();
			foreach ($arrTagsWithCount as $data)
			{
				$countarray[$data['tag']] = $data['tagcount'];
			}
			foreach ($arrTags as $idx => $tag)
			{
				$arrTags[$idx]['tagcount'] = $countarray[$tag['tag']];
				$arrTags[$idx]['tag_class'] = TagList::_getTagNameClass($tag['tag']);
			}
			if ($relevance == 1)
			{
				usort($arrTags, array(TagHelper::class, 'sortTagsByRelevance'));
			}
			if (strlen($target))
			{
				$pageArr = array();
				$objFoundPage = Database::getInstance()->prepare("SELECT id, alias FROM tl_page WHERE id=? OR alias=?")
					->limit(1)
					->execute($target, $target);
				$pageArr = ($objFoundPage->numRows) ? $objFoundPage->fetchAssoc() : array();
				if (count($pageArr))
				{
					foreach ($arrTags as $idx => $tag)
					{
						$arrTags[$idx]['url'] = StringUtil::ampersand($objPage->getFrontendUrl('/tag/' . TagHelper::encode($tag['tag'])));
					}
				}
			}
		}
		return $arrTags;
	}

	public function getTagsAndTaglistForIdAndTable($id, $table, $jumpto)
	{
		$pageObj = TagHelper::getPageObj($jumpto);
		
		$tags = $this->getTags($id, $table);
		$taglist = array();
		foreach ($tags as $id => $tag)
		{
			$strUrl = \Contao\StringUtil::ampersand($pageObj->getFrontendUrl('/tag/' . TagHelper::encode($tag)));
			if (strlen(Contao\Environment::get('queryString'))) $strUrl .= "?" . \Contao\Environment::get('queryString');
			$tags[$id] = '<a href="' . $strUrl . '">' . \Contao\StringUtil::specialchars($tag) . '</a>';
			$taglist[$id] = array(
				'url' => $tags[$id],
				'tag' => $tag,
				'class' => TagList::_getTagNameClass($tag)
			);
		}
		return array(
			'tags' => $tags,
			'taglist' => $taglist
		);
	}
	
	/**
	 * Check for modified calendar feeds and update the XML files if necessary
	 */
	public function generateEventFeed()
	{
		//$this->import('CalendarTags');
		//$this->CalendarTags->generateFeedsByCalendar($id);
	}

	/**
	 * Check for modified news feeds and update the XML files if necessary
	 */
	public function generateNewsFeed()
	{
		//$this->import('NewsTags');
		//$this->NewsTags->generateFeedsByArchive($id);
	}
}

