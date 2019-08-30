<?php

namespace Contao;

/**
 * Contao Open Source CMS - tags extension
 *
 * Copyright (c) 2008-2016 Helmut Schottmüller
 *
 * @license LGPL-3.0+
 */

class TagHelper extends \Backend
{
	/**
	 * Load the database object
	 */
	public function __construct()
	{
		parent::__construct();
		$this->import('Database');
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
		$arrTables = $this->Database->prepare("SELECT DISTINCT tl_tag.from_table FROM tl_tag")
			->execute()
			->fetchEach('from_table');
		foreach ($arrTables as $table)
		{
			$ids = $this->Database->prepare("select DISTINCT tl_tag.tid from tl_tag left join " . $table . " on tl_tag.tid = " . $table . ".id where tl_tag.from_table = ? and " . $table . ".id is null")
				->execute($table)
				->fetchEach('tid');
			foreach ($ids as $id)
			{
				$this->Database->prepare("DELETE FROM tl_tag WHERE tid = ? AND from_table = ?")
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
		$ids = $this->Database->prepare("select DISTINCT tl_tag.tid from tl_tag left join " . $table . " on tl_tag.tid = " . $table . ".id where tl_tag.from_table = ? and " . $table . ".id is null")
			->execute($table)
			->fetchEach('tid');
		foreach ($ids as $id)
		{
			$this->Database->prepare("DELETE FROM tl_tag WHERE tid = ? AND from_table = ?")
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
				$ids = $this->Database->prepare("SELECT tl_tag.tid FROM tl_tag, $table WHERE tl_tag.tid = $table.id AND $table.tstamp = 0")
					->execute()
					->fetchEach('tid');
				if (count($ids))
				{
					$this->Database->prepare("DELETE FROM tl_tag WHERE tid IN (" . join($ids, ",") . ") AND from_table = ?")
						->execute($table);
				}
			}
		}
	}

	/**
	 * Read tags from database
	 * @return string
	 */
	protected function getTags($id, $table)
	{
		return $this->Database->prepare("SELECT tag FROM tl_tag WHERE tid = ? AND from_table = ? ORDER BY tag ASC")
			->execute($id, $table)
			->fetchEach('tag');
	}

	public function sortByRelevance($a, $b)
	{
		if ($a['tagcount'] == $b['tagcount'])
		{
			return 0;
		}
		return ($a['tagcount'] < $b['tagcount']) ? 1 : -1;
	}

	private function getTagsForTableAndId($table, $id, $url = false, $max_tags = 0, $relevance = 0, $target = 0)
	{
		$arrTags = $this->Database->prepare("SELECT * FROM tl_tag WHERE from_table = ? AND tid = ? ORDER BY tag ASC")
			->execute($table, $id)
			->fetchAllAssoc();
		$res = false;
		if (count($arrTags))
		{
			$arrTagsWithCount = $this->Database->prepare("SELECT tag, COUNT(tag) as tagcount FROM tl_tag WHERE from_table = ? GROUP BY tag ORDER BY tag ASC")
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
				usort($arrTags, array($this, 'sortByRelevance'));
			}
			if ($max_tags > 0)
			{
				$arrTags = array_slice($arrTags,0,$max_tags);
			}
			if (strlen($target))
			{
				$pageArr = array();
				$objFoundPage = $this->Database->prepare("SELECT id, alias FROM tl_page WHERE id=? OR alias=?")
					->limit(1)
					->execute(array($target, $target));
				$pageArr = ($objFoundPage->numRows) ? $objFoundPage->fetchAssoc() : array();
				if (count($pageArr))
				{
					foreach ($arrTags as $idx => $tag)
					{
						$arrTags[$idx]['url'] = ampersand($this->generateFrontendUrl($pageArr, '/tag/' . $tag['tag']));
					}
				}
			}
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
							foreach ($arrTags as $idx => $tag)
							{
								$arrTags[$idx]['url'] = $this->generateFrontendUrl($objArticle->row(), '/articles/' . ((!$GLOBALS['TL_CONFIG']['disableAlias'] && strlen($objArticle->aAlias)) ? $objArticle->aAlias : $objArticle->aId));
							}
							$objTemplate->url = $this->generateFrontendUrl($objArticle->row(), '/articles/' . ((!$GLOBALS['TL_CONFIG']['disableAlias'] && strlen($objArticle->aAlias)) ? $objArticle->aAlias : $objArticle->aId));
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

	public function replaceTagInsertTags($strTag)
	{
		if ($strTag == 'tags_used')
		{
			$headlinetags = array();
			$relatedlist = (strlen($this->Input->get('related'))) ? preg_split("/,/", $this->Input->get('related')) : array();
			if (strlen($this->Input->get('tag', true)))
			{
				$headlinetags = array_merge($headlinetags, array($this->Input->get('tag', true)));
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
		$max_tags = (count($elements) > 2) ? $elements[2] : 0;
		$relevance = (count($elements) > 3) ? $elements[3] : 0;
		$target = (count($elements) > 4) ? $elements[4] : 0;
		switch ($elements[0])
		{
			case 'tags_news':
				return $this->getTagsForTableAndId('tl_news', $elements[1], false, $max_tags, $relevance, $target);
				break;
			case 'tags_file':
				return $this->getTagsForTableAndId('tl_files', $elements[1], false, $max_tags, $relevance, $target);
				break;
			case 'tags_faq':
				return $this->getTagsForTableAndId('tl_faq', $elements[1], false, $max_tags, $relevance, $target);
				break;
			case 'tags_event':
				return $this->getTagsForTableAndId('tl_calendar_events', $elements[1], false, $max_tags, $relevance, $target);
				break;
			case 'tags_article':
				return $this->getTagsForTableAndId('tl_article', $elements[1], false, $max_tags, $relevance, $target);
				break;
			case 'tags_article_url':
				return $this->getTagsForTableAndId('tl_article', $elements[1], true);
				break;
			case 'tags_content':
				return $this->getTagsForTableAndId('tl_content', $elements[1], false, $max_tags, $relevance, $target);
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
			$tags = $this->getTags($row['id'], 'tl_news');
			$taglist = array();
			foreach ($tags as $id => $tag)
			{
				$strUrl = ampersand($this->generateFrontendUrl($pageArr, $items . '/tag/' . \System::urlencode($tag)));
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

	public function getTagsAndTaglistForIdAndTable($id, $table, $jumpto)
	{
		$pageArr = array();
		if (strlen($jumpto))
		{
			$objFoundPage = $this->Database->prepare("SELECT id, alias FROM tl_page WHERE id=?")
				->limit(1)
				->execute($jumpto);
			$pageArr = ($objFoundPage->numRows) ? $objFoundPage->fetchAssoc() : array();
		}
		if (count($pageArr) == 0)
		{
			global $objPage;
			$pageArr = $objPage->row();
		}
		$tags = $this->getTags($id, $table);
		$taglist = array();
		foreach ($tags as $id => $tag)
		{
			$strUrl = ampersand($this->generateFrontendUrl($pageArr, $items . '/tag/' . \System::urlencode($tag)));
			if (strlen(\Environment::get('queryString'))) $strUrl .= "?" . \Environment::get('queryString');
			$tags[$id] = '<a href="' . $strUrl . '">' . specialchars($tag) . '</a>';
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

