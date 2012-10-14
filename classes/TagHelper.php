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
 * @copyright  Helmut Schottmüller 2008-2010
 * @author     Helmut Schottmüller <contao@aurealis.de>
 * @package    memberextensions
 * @license    LGPL
 * @filesource
 */

/**
 * Class TagHelper
 *
 * Helper class for tags
 * @copyright  Helmut Schottmüller 2008-2010
 * @author     Helmut Schottmüller <contao@aurealis.de>
 * @package    Controller
 */

namespace Contao;

class TagHelper extends \System
{
	/**
	 * Load the database object
	 */
	protected function __construct()
	{
		parent::__construct();
		$this->import('Database');
	}

	/*
	* Cleanup all tags that are associated to no longer existing TYPOlight objects
	*/
	public function deleteUnusedTags()
	{
		// fetch all tables
		$arrTables = $this->Database->prepare("SELECT DISTINCT tl_tag.from_table FROM tl_tag")
			->execute()
			->fetchEach('from_table');
		foreach ($arrTables as $table)
		{
			$ids = $this->Database->prepare("select DISTINCT tl_tag.id from tl_tag left join " . $table . " on tl_tag.id = " . $table . ".id where tl_tag.from_table = ? and " . $table . ".id is null")
				->execute($table)
				->fetchEach('id');
			foreach ($ids as $id)
			{
				$this->Database->prepare("DELETE FROM tl_tag WHERE id = ? AND from_table = ?")
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
			$strParams = join($arrParams, '&');
		}
		return $strParams;
	}
	
	/*
	* Cleanup all tags that are associated to no longer existing TYPOlight objects
	*/
	public function deleteUnusedTagsForTable($table, $new_records, $parent_table, $child_tables)
	{
		$ids = $this->Database->prepare("select DISTINCT tl_tag.id from tl_tag left join " . $table . " on tl_tag.id = " . $table . ".id where tl_tag.from_table = ? and " . $table . ".id is null")
			->execute($table)
			->fetchEach('id');
		foreach ($ids as $id)
		{
			$this->Database->prepare("DELETE FROM tl_tag WHERE id = ? AND from_table = ?")
				->execute($id, $table);
		}
	}

	/*
	* Cleanup tags and remove all tags which are associated to incomplete records
	*/
	public function deleteIncompleteRecords($table, $new_records, $parent_table, $child_tables)
	{
		if (is_array($new_records))
		{
			foreach ($new_records as $id)
			{
				$ids = $this->Database->prepare("SELECT tl_tag.id FROM tl_tag, $table WHERE tl_tag.id = $table.id AND $table.tstamp = 0")
					->execute()
					->fetchEach('id');
				if (count($ids))
				{
					$this->Database->prepare("DELETE FROM tl_tag WHERE id IN (" . join($ids, ",") . ") AND from_table = ?")
						->execute($table);
				}
			}
		}
	}
	
	/**
	 * Read tags from database
	 * @return string
	 */
	protected function getTags($id)
	{
		return $this->Database->prepare("SELECT * FROM tl_tag WHERE id = ? AND from_table = ? ORDER BY tag ASC")
			->execute($id, 'tl_news')
			->fetchEach('tag');
	}

	private function getTagsForTableAndId($table, $id, $url = false)
	{
		$arrTags = $this->Database->prepare("SELECT * FROM tl_tag WHERE from_table = ? AND id = ?")
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
						$objArticle = $this->Database->prepare("SELECT a.id AS aId, a.alias AS aAlias, a.title AS title, p.id AS id, p.alias AS alias FROM tl_article a, tl_page p WHERE a.pid=p.id AND (a.id=? OR a.alias=?)")
							->limit(1)
							->execute($id, $id);
						if ($objArticle->numRows < 1)
						{
							break;
						}
						else
						{
							$strUrl = $this->generateFrontendUrl($objArticle->row(), '/articles/' . ((!$GLOBALS['TL_CONFIG']['disableAlias'] && strlen($objArticle->aAlias)) ? $objArticle->aAlias : $objArticle->aId));
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
	
	public function replaceTagInsertTags($strTag)
	{
		if ($strTag == 'tags_used')
		{
			$headlinetags = array();
			$relatedlist = (strlen(\Input::get('related'))) ? preg_split("/,/", \Input::get('related')) : array();
			if (strlen(\Input::get('tag')))
			{
				$headlinetags = array_merge($headlinetags, array(\Input::get('tag')));
				if (count($relatedlist))
				{
					$headlinetags = array_merge($headlinetags, $relatedlist);
				}
			}
			if (count($headlinetags))
			{
				$objTemplate = new FrontendTemplate('tags_used');
				$objTemplate->tags = $headlinetags;
				return $objTemplate->parse();
			}
		}
		$elements = explode('::', $strTag);
		switch ($elements[0])
		{
			case 'tags_news':
				return $this->getTagsForTableAndId('tl_news', $elements[1]);
				break;
			case 'tags_event':
				return $this->getTagsForTableAndId('tl_calendar_events', $elements[1]);
				break;
			case 'tags_article':
				return $this->getTagsForTableAndId('tl_article', $elements[1]);
				break;
			case 'tags_article_url':
				return $this->getTagsForTableAndId('tl_article', $elements[1], true);
				break;
			case 'tags_content':
				return $this->getTagsForTableAndId('tl_content', $elements[1]);
				break;
		}
		return false;
	}

	public function parseArticlesHook($objTemplate, $row)
	{
		$this->import('Session');
		$news_showtags = $this->Session->get('news_showtags');
		$news_jumpto = $this->Session->get('news_jumpto');
		$tag_named_class = $this->Session->get('news_tag_named_class');
		$objTemplate->showTags = $news_showtags;
		if ($news_showtags)
		{
			$pageArr = array();
			if (strlen($news_jumpto))
			{
				$objFoundPage = $this->Database->prepare("SELECT id, alias FROM tl_page WHERE id=?")
					->limit(1)
					->execute($news_jumpto);
				$pageArr = ($objFoundPage->numRows) ? $objFoundPage->fetchAssoc() : array();
			}
			if (count($pageArr) == 0)
			{
				global $objPage;
				$pageArr = $objPage->row();
			}
			$tags = $this->getTags($row['id']);
			$taglist = array();
			foreach ($tags as $id => $tag)
			{
				$strUrl = ampersand($this->generateFrontendUrl($pageArr, $items . '/tag/' . str_replace(' ', '+', $tag)));
				$tags[$id] = '<a href="' . $strUrl . '">' . specialchars($tag) . '</a>';
				$taglist[$id] = array(
					'url' => $tags[$id],
					'tag' => $tag,
					'class' => TagList::_getTagNameClass($tag)
				);
			}
			$objTemplate->showTagClass = $tag_named_class;
			$objTemplate->tags = $tags;
			$objTemplate->taglist = $taglist;
		}
	}
	
	/**
	 * Check for modified calendar feeds and update the XML files if necessary
	 */
	public function generateEventFeed()
	{
		$session = $this->Session->get('calendar_feed_updater');

		if (!is_array($session) || count($session) < 1)
		{
			return;
		}

		$this->import('CalendarTags');

		foreach ($session as $id)
		{
			$this->CalendarTags->generateFeed($id);
		}

		$this->Session->set('calendar_feed_updater', null);
	}

	/**
	 * Check for modified news feeds and update the XML files if necessary
	 */
	public function generateNewsFeed()
	{
		$session = $this->Session->get('news_feed_updater');

		if (!is_array($session) || count($session) < 1)
		{
			return;
		}

		$this->import('NewsTags');

		foreach ($session as $id)
		{
			$this->NewsTags->generateFeed($id);
		}

		$this->Session->set('news_feed_updater', null);
	}
}

?>