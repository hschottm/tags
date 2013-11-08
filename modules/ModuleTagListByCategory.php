<?php

namespace Contao;

if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Class ModuleTagListByCategory
 *
 * Front end module "tag list by category".
 * @copyright  Helmut Schottmüller 2011
 * @author     Helmut Schottmüller <contao@aurealis.de>
 * @package    Controller
 */
class ModuleTagListByCategory extends \Module
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_tag_listbycategory';
	protected $sourcetables = array();
	protected $arrPages = array();
	protected $arrTags = array();


	/**
	 * Do not display the module if there are no articles
	 * @return string
	 */
	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new BackendTemplate('be_wildcard');
			$objTemplate->wildcard = '### Tag List by Category ###';

			return $objTemplate->parse();
		}
		if (strlen($this->tag_sourcetables)) $this->sourcetables = deserialize($this->tag_sourcetables, TRUE);

		$this->getRelevantPages($this->pagesource);
//		$this->getTags();
		return parent::generate();
	}
	
 	/**
	 * Generate module
	 */
	protected function compile()
	{
		if (strlen(\Input::get('tag')) && count($this->sourcetables) > 0)
		{
			$tagids = array();
			$tagid_cats = array();
			$relatedlist = (strlen(\Input::get('related'))) ? preg_split("/,/", \Input::get('related')) : array();
			$alltags = array_merge(array(\Input::get('tag')), $relatedlist);
			$first = true;
			$marks = array();
			foreach ($this->sourcetables as $table)
			{
				array_push($marks, '?');
			}
			foreach ($alltags as $tag)
			{
				if (strlen(trim($tag)))
				{
					if (count($tagids))
					{
						$found = $this->Database->prepare("SELECT tid, from_table FROM tl_tag WHERE from_table = IN (" . implode(',', $marks) . ") AND tag = ? AND tid IN (" . join($tagids, ",") . ")")
							->execute(array_merge($this->sourcetables, array($tag)))
							->fetchAllAssoc();
						foreach ($found as $data)
						{
							array_push($tagids, $data['tid']);
							if (!array_key_exists($data['from_table'], $tagid_cats)) $tagid_cats[$data['from_table']] = array();
							array_push($tagid_cats[$data['from_table']], $data['tid']);
						}
					}
					else if ($first)
					{
						$found = $this->Database->prepare("SELECT tid, from_table FROM tl_tag WHERE from_table IN (" . implode(',', $marks) . ") AND tag = ?")
							->execute(array_merge($this->sourcetables, array($tag)))
							->fetchAllAssoc();
						foreach ($found as $data)
						{
							array_push($tagids, $data['tid']);
							if (!array_key_exists($data['from_table'], $tagid_cats)) $tagid_cats[$data['from_table']] = array();
							array_push($tagid_cats[$data['from_table']], $data['tid']);
						}
						$first = false;
					}
				}
			}
			$pages = array();
			foreach ($this->sourcetables as $sourcetable)
			{
				switch ($sourcetable)
				{
					case 'tl_news':
						$this->Template->news = $this->getNewsForNewsTags($tagid_cats[$sourcetable]);
						break;
					case 'tl_calendar_events':
						$this->Template->events = $this->getEventsForEventTags($tagid_cats[$sourcetable]);
						break;
					case 'tl_content':
						$pages = array_merge($pages, $this->getPagesForContentTags($tagid_cats[$sourcetable]));
//						$this->Template->contentElements = $this->getContentElementsForContentTags($tagid_cats[$sourcetable]);
						break;
					case 'tl_article':
						$this->Template->articles = $this->getArticlesForArticleTags($tagid_cats[$sourcetable]);
						$pages = array_merge($pages, $this->getPagesForArticleTags($tagid_cats[$sourcetable]));
						break;
				}
			}
			$uniquepages = array();
			foreach ($pages as $page)
			{
				$uniquepages[$page['id']] = $page;
			}
			$this->Template->pages = $uniquepages;
		}
		$this->Template->lngArticles = $GLOBALS['TL_LANG']['tl_module']['tl_article'];
		$this->Template->lngPages = $GLOBALS['TL_LANG']['tl_module']['tl_page'];
		$this->Template->lngContentElements = $GLOBALS['TL_LANG']['tl_module']['tl_content'];
		$this->Template->lngNews = $GLOBALS['TL_LANG']['tl_module']['tl_news'];
		$this->Template->lngEvents = $GLOBALS['TL_LANG']['tl_module']['tl_calendar_events'];
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

	protected function getNewsForNewsTags($tagids)
	{
		$time = time();
		if (count($tagids))
		{
			$objArticles = $this->Database->prepare("SELECT *, author AS authorId, (SELECT title FROM tl_news_archive WHERE tl_news_archive.id=tl_news.pid) AS archive, (SELECT jumpTo FROM tl_news_archive WHERE tl_news_archive.id=tl_news.pid) AS parentJumpTo, (SELECT name FROM tl_user WHERE id=author) AS author FROM tl_news WHERE id IN (" . join($tagids, ",") . ")" . (!BE_USER_LOGGED_IN ? " AND (start='' OR start<$time) AND (stop='' OR stop>$time) AND published=1" : "") . " ORDER BY date DESC");
			return $objArticles->execute()->fetchAllAssoc();
		}
		else
		{
			return array();
		}
	}

	protected function getEventsForEventTags($tagids)
	{
		$time = time();
		if (count($tagids))
		{
			$objEvents = $this->Database->prepare("SELECT *, (SELECT name FROM tl_user WHERE id=author) author FROM tl_calendar_events WHERE id IN (" . join($tagids, ",") . ") " . (!BE_USER_LOGGED_IN ? " AND (start='' OR start<$time) AND (stop='' OR stop>$time) AND published=1" : "") . " ORDER BY startTime")
										->execute($intStart, $intEnd, $intStart, $intEnd, $intStart, $intEnd, $intStart, $intEnd);
			return $objEvents->fetchAllAssoc();
		}
		else
		{
			return array();
		}
	}

	protected function getPagesForArticleTags($tags)
	{
		$pages = array();
		if (count($this->arrPages) && count($tags))
		{
			$time = time();
			$arrArticles = $this->Database->prepare("SELECT id FROM tl_article WHERE id IN (" . join($tags, ',') . ") AND pid IN (" . join($this->arrPages, ',') . ") " . (!BE_USER_LOGGED_IN ? " AND (start='' OR start<?) AND (stop='' OR stop>?) AND published=1" : "") . " ORDER BY sorting")
				->execute($time, $time)->fetchEach('id');
			if (count($arrArticles))
			{
				$pages = $this->Database->prepare("SELECT DISTINCT tl_page.id, tl_page.* FROM tl_page, tl_article WHERE tl_article.id IN (" . join($arrArticles, ',') . ") AND tl_article.pid = tl_page.id ORDER BY tl_page.sorting")
					->execute()->fetchAllAssoc();
			}
		}
		return $pages;
	}

	protected function getArticlesForArticleTags($tags)
	{
		$articles = array();
		if (count($this->arrPages) && count($tags))
		{
			$time = time();
			$articles = $this->Database->prepare("SELECT DISTINCT id, tl_article.* FROM tl_article WHERE id IN (" . join($tags, ',') . ") AND pid IN (" . join($this->arrPages, ',') . ") " . (!BE_USER_LOGGED_IN ? " AND (start='' OR start<?) AND (stop='' OR stop>?) AND published=1" : "") . " ORDER BY sorting")
				->execute($time, $time)
				->fetchAllAssoc();
		}
		return $articles;
	}

	protected function getPagesForContentTags($tags)
	{
		$pages = array();
		if (count($this->arrPages) && count($tags))
		{
			$time = time();
			$arrArticles = $this->Database->prepare("SELECT id FROM tl_article WHERE pid IN (" . join($this->arrPages, ',') . ") " . (!BE_USER_LOGGED_IN ? " AND (start='' OR start<?) AND (stop='' OR stop>?) AND published=1" : "") . " ORDER BY sorting")
				->execute($time, $time)->fetchEach('id');
			if (count($arrArticles))
			{
				$arrContentElements = $this->Database->prepare("SELECT id FROM tl_content WHERE  id IN (" . join($tags, ',') . ") AND pid IN (" . join($arrArticles, ',') . ") " . (!BE_USER_LOGGED_IN ? " AND invisible<>1" : "") . " ORDER BY sorting")
					->execute()->fetchEach('id');
				if (count($arrContentElements))
				{
					$pages = $this->Database->prepare("SELECT DISTINCT tl_page.id, tl_page.* FROM tl_page, tl_article, tl_content WHERE tl_content.id IN (" . join($arrContentElements, ',') . ") AND tl_content.pid = tl_article.id  AND tl_article.pid = tl_page.id ORDER BY tl_page.sorting")
						->execute()->fetchAllAssoc();
				}
			}
		}
		return $pages;
	}
}

?>