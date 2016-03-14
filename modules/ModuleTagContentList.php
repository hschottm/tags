<?php

namespace Contao;

/**
 * Contao Open Source CMS - tags extension
 *
 * Copyright (c) 2008-2016 Helmut Schottmüller
 *
 * @license LGPL-3.0+
 */

class ModuleTagContentList extends \Module
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_tag_contentlist';
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
			$objTemplate->wildcard = '### Tag Content List ###';

			return $objTemplate->parse();
		}
		$this->getRelevantPages($this->pagesource);
		$this->getTags();
		return parent::generate();
	}
	
	protected function getArticlesForTagSource($sourcetable)
	{
		$articles = array();
		$id = $objPage->id;

		$this->Template->request = \Environment::get('request');

		$time = time();

		// Get published articles
		$objArticles = $this->Database->prepare("SELECT id, title, inColumn, cssID FROM tl_article" . (!BE_USER_LOGGED_IN ? " WHERE (start='' OR start<?) AND (stop='' OR stop>?) AND published=1" : "") . " ORDER BY title")
			->execute($time, $time);

		$tagids = array();
		if (strlen(\Input::get('tag')))
		{
			$limit = null;
			$offset = 0;
			
			$objIds = $this->Database->prepare("SELECT tid FROM tl_tag WHERE from_table = ? AND tag = ?")
				->execute('tl_article', \Input::get('tag'));
			if ($objIds->numRows)
			{
				while ($objIds->next())
				{
					array_push($tagids, $objIds->tid);
				}
			}
		}
		while ($objArticles->next())
		{
			$cssID = deserialize($objArticles->cssID, true);

			$objArticle = $this->Database->prepare("SELECT a.id AS aId, a.alias AS aAlias, a.title AS title, p.id AS id, p.alias AS alias, a.teaser FROM tl_article a, tl_page p WHERE a.pid=p.id AND (a.id=? OR a.alias=?)")
										 ->limit(1)
										 ->execute($objArticles->id, $objArticles->id);

			if ($objArticle->numRows)
			{
				if (count($tagids))
				{
					if (in_array($objArticle->aId, $tagids))
					{
						if ($this->linktoarticles)
						{ // link to articles
							$articles[] = array('content' => '<a href="' . $this->generateFrontendUrl($objArticle->row(), '/articles/' . ((!$GLOBALS['TL_CONFIG']['disableAlias'] && strlen($objArticle->aAlias)) ? $objArticle->aAlias : $objArticle->aId)) . '" title="' . specialchars($objArticle->title) . '">' . $objArticle->title . '</a>', 'tags' => $taglist, 'data' => $objArticle->row());
						}
						else
						{ // link to pages
							$articles[] = array('content' => '<a href="' . $this->generateFrontendUrl($objArticle->row()) . '" title="' . specialchars($objArticle->title) . '">' . $objArticle->title . '</a>', 'tags' => $taglist, 'data' => $objArticle->row());
						}
					}
				}
			}
		}
		$relatedlist = (strlen(\Input::get('related'))) ? preg_split("/,/", \Input::get('related')) : array();
		$headlinetags = array_merge(array(\Input::get('tag')), $relatedlist);
		$this->Template->tags_activetags = $headlinetags;
		$this->Template->articles = $articles;
		$this->Template->empty = $GLOBALS['TL_LANG']['MSC']['emptyarticles'];
	}

	protected function getPages()
	{
		$pages = array();
		switch ($this->tagsource)
		{
			case 'tl_content':
				$pages = $this->getPagesForContentTags();
				break;
			case 'tl_article':
				$pages = $this->getPagesForArticleTags();
				break;
		}
		return $pages;
	}
	
	protected function getArticles()
	{
		$articles = array();
		switch ($this->tagsource)
		{
			case 'tl_content':
				$articles = $this->getArticlesForContentTags();
				break;
			case 'tl_article':
				$articles = $this->getArticlesForArticleTags();
				break;
		}
		return $articles;
	}

	protected function getContentElements()
	{
		$ctes = array();
		switch ($this->tagsource)
		{
			case 'tl_content':
				$ctes = $this->getContentElementsForContentTags();
				break;
			case 'tl_article':
				$ctes = $this->getContentElementsForArticleTags();
				break;
		}
		return $ctes;
	}
	
	protected function getTags()
	{
		$this->arrTags = array();
		if (strlen(\Input::get('tag')))
		{
			$this->arrTags = $this->Database->prepare("SELECT tid FROM tl_tag WHERE from_table = ? AND tag = ?")
				->execute($this->tagsource, \Input::get('tag'))
				->fetchEach('tid');
		}
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

	protected function getContentElementsForArticleTags()
	{
		$arrArticles = array();
		$ctes = array();
		if (count($this->arrPages) && count($this->arrTags))
		{
			$time = time();
			$arrArticles = $this->Database->prepare("SELECT id FROM tl_article WHERE id IN (" . join($this->arrTags, ',') . ") AND pid IN (" . join($this->arrPages, ',') . ") " . (!BE_USER_LOGGED_IN ? " AND (start='' OR start<?) AND (stop='' OR stop>?) AND published=1" : "") . " ORDER BY sorting")
				->execute($time, $time)
				->fetchEach('id');
			if (count($arrArticles))
			{
				$ctes = $this->Database->prepare("SELECT DISTINCT id, tl_content.* FROM tl_content WHERE pid IN (" . join($arrArticles, ',') . ") " . (!BE_USER_LOGGED_IN ? " AND invisible<>1" : "") . " ORDER BY sorting")
					->execute()
					->fetchAllAssoc();
			}
		}
		return $ctes;
	}

	protected function getContentElementsForContentTags()
	{
		$ctes = array();
		if (count($this->arrPages) && count($this->arrTags))
		{
			$time = time();
			$arrArticles = $this->Database->prepare("SELECT id FROM tl_article WHERE pid IN (" . join($this->arrPages, ',') . ") " . (!BE_USER_LOGGED_IN ? " AND (start='' OR start<?) AND (stop='' OR stop>?) AND published=1" : "") . " ORDER BY sorting")
				->execute($time, $time)->fetchEach('id');
			if (count($arrArticles))
			{
				$ctes = $this->Database->prepare("SELECT DISTINCT id, tl_content.* FROM tl_content WHERE id IN (" . join($this->arrTags, ',') . ") AND pid IN (" . join($arrArticles, ',') . ") " . (!BE_USER_LOGGED_IN ? " AND invisible<>1" : "") . " ORDER BY sorting")
					->execute()
					->fetchAllAssoc();
			}
		}
		return $ctes;
	}

	protected function getArticlesForArticleTags()
	{
		$articles = array();
		if (count($this->arrPages) && count($this->arrTags))
		{
			$time = time();
			$articles = $this->Database->prepare("SELECT DISTINCT id, tl_article.* FROM tl_article WHERE id IN (" . join($this->arrTags, ',') . ") AND pid IN (" . join($this->arrPages, ',') . ") " . (!BE_USER_LOGGED_IN ? " AND (start='' OR start<?) AND (stop='' OR stop>?) AND published=1" : "") . " ORDER BY sorting")
				->execute($time, $time)
				->fetchAllAssoc();
		}
		return $articles;
	}

	protected function getArticlesForContentTags()
	{
		$articles = array();
		if (count($this->arrPages) && count($this->arrTags))
		{
			$time = time();
			$arrArticles = $this->Database->prepare("SELECT id FROM tl_article WHERE pid IN (" . join($this->arrPages, ',') . ") " . (!BE_USER_LOGGED_IN ? " AND (start='' OR start<?) AND (stop='' OR stop>?) AND published=1" : "") . " ORDER BY sorting")
				->execute($time, $time)->fetchEach('id');
			if (count($arrArticles))
			{
				$arrContentElements = $this->Database->prepare("SELECT id FROM tl_content WHERE  id IN (" . join($this->arrTags, ',') . ") AND pid IN (" . join($arrArticles, ',') . ") " . (!BE_USER_LOGGED_IN ? " AND invisible<>1" : "") . " ORDER BY sorting")
					->execute()->fetchEach('id');
				if (count($arrContentElements))
				{
					$articles = $this->Database->prepare("SELECT DISTINCT tl_article.id, tl_article.* FROM tl_article, tl_content WHERE tl_content.id IN (" . join($arrContentElements, ',') . ") AND tl_content.pid = tl_article.id ORDER BY tl_article.sorting")
						->execute()
						->fetchAllAssoc();
				}
			}
		}
		return $articles;
	}

	protected function getPagesForArticleTags()
	{
		$pages = array();
		if (count($this->arrPages) && count($this->arrTags))
		{
			$time = time();
			$arrArticles = $this->Database->prepare("SELECT id FROM tl_article WHERE id IN (" . join($this->arrTags, ',') . ") AND pid IN (" . join($this->arrPages, ',') . ") " . (!BE_USER_LOGGED_IN ? " AND (start='' OR start<?) AND (stop='' OR stop>?) AND published=1" : "") . " ORDER BY sorting")
				->execute($time, $time)->fetchEach('id');
			if (count($arrArticles))
			{
				$pages = $this->Database->prepare("SELECT DISTINCT tl_page.id, tl_page.* FROM tl_page, tl_article WHERE tl_article.id IN (" . join($arrArticles, ',') . ") AND tl_article.pid = tl_page.id ORDER BY tl_page.sorting")
					->execute()->fetchAllAssoc();
			}
		}
		return $pages;
	}

	protected function getPagesForContentTags()
	{
		$pages = array();
		if (count($this->arrPages) && count($this->arrTags))
		{
			$time = time();
			$arrArticles = $this->Database->prepare("SELECT id FROM tl_article WHERE pid IN (" . join($this->arrPages, ',') . ") " . (!BE_USER_LOGGED_IN ? " AND (start='' OR start<?) AND (stop='' OR stop>?) AND published=1" : "") . " ORDER BY sorting")
				->execute($time, $time)->fetchEach('id');
			if (count($arrArticles))
			{
				$arrContentElements = $this->Database->prepare("SELECT id FROM tl_content WHERE  id IN (" . join($this->arrTags, ',') . ") AND pid IN (" . join($arrArticles, ',') . ") " . (!BE_USER_LOGGED_IN ? " AND invisible<>1" : "") . " ORDER BY sorting")
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

 	/**
	 * Generate module
	 */
	protected function compile()
	{
		global $objPage;

		switch ($this->objecttype)
		{
			case 'tl_content':
				$this->Template->contentElements = $this->getContentElements();
				break;
			case 'tl_article':
				$this->Template->articles = $this->getArticles();
				break;
			case 'tl_page':
				$this->Template->pages = $this->getPages();
				break;
		}
	}
}

