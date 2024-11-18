<?php

namespace Hschottm\TagsBundle;

use Contao\System;
use Contao\Module;
use Contao\BackendTemplate;
use Contao\Database;
use Contao\Input;
use Contao\Environment;
use Contao\StringUtil;

/**
 * Contao Open Source CMS - tags extension
 *
 * Copyright (c) 2008-2024 Helmut Schottmüller
 *
 * @license LGPL-3.0+
 */

class ModuleTagContentList extends Module
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
		$request = System::getContainer()->get('request_stack')->getCurrentRequest();
		if ($request && System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest($request))
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
		global $objPage;

		$hasBackendUser = System::getContainer()->get('contao.security.token_checker')->hasBackendUser();
		$showUnpublished = System::getContainer()->get('contao.security.token_checker')->isPreviewMode();
		$hasFrontendUser = System::getContainer()->get('contao.security.token_checker')->hasFrontendUser();

		$articles = array();
		$id = $objPage->id;

		$this->Template->request = Environment::get('request');

		$time = time();

		// Get published articles
		if (!$hasBackendUser) {
			$objArticles = Database::getInstance()->prepare("SELECT id, title, inColumn, cssID FROM tl_article" . " WHERE (start='' OR start<?) AND (stop='' OR stop>?) AND published=1"  . " ORDER BY title")
			->execute($time, $time);
		} else {
			$objArticles = Database::getInstance()->prepare("SELECT id, title, inColumn, cssID FROM tl_article" .  " ORDER BY title")
			->execute();
		}

		$tagids = array();
		if (strlen(TagHelper::decode(Input::get('tag'))))
		{
			$limit = null;
			$offset = 0;
			
			$objIds = Database::getInstance()->prepare("SELECT tid FROM tl_tag WHERE from_table = ? AND tag = ?")
				->execute('tl_article', TagHelper::decode(Input::get('tag')));
			if ($objIds->numRows)
			{
				while ($objIds->next())
				{
					\array_push($tagids, $objIds->tid);
				}
			}
		}
		while ($objArticles->next())
		{
			$cssID = StringUtil::deserialize($objArticles->cssID, true);

			$objArticle = Database::getInstance()->prepare("SELECT a.id AS aId, a.alias AS aAlias, a.title AS title, p.id AS id, p.alias AS alias, a.teaser FROM tl_article a, tl_page p WHERE a.pid=p.id AND (a.id=? OR a.alias=?)")
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
							$articles[] = array('content' => '<a href="' . TagHelper::getPageObj($objArticle->tags_jumpto)->getFrontendUrl('/articles/' . ((!$GLOBALS['TL_CONFIG']['disableAlias'] && strlen($objArticle->aAlias)) ? $objArticle->aAlias : $objArticle->aId)) . '" title="' . StringUtil::specialchars($objArticle->title) . '">' . $objArticle->title . '</a>', 'tags' => $taglist, 'data' => $objArticle->row());
						}
						else
						{ // link to pages
							$articles[] = array('content' => '<a href="' . TagHelper::getPageObj($objArticle->tags_jumpto)->getFrontendUrl() . '" title="' . StringUtil::specialchars($objArticle->title) . '">' . $objArticle->title . '</a>', 'tags' => $taglist, 'data' => $objArticle->row());
						}
					}
				}
			}
		}
		$relatedlist = (strlen(TagHelper::decode(Input::get('related')))) ? preg_split("/,/", TagHelper::decode(Input::get('related'))) : array();
		$headlinetags = array_merge(array(TagHelper::decode(Input::get('tag'))), $relatedlist);
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
		if (strlen(TagHelper::decode(Input::get('tag'))))
		{
			$this->arrTags = Database::getInstance()->prepare("SELECT tid FROM tl_tag WHERE from_table = ? AND tag = ?")
				->execute($this->tagsource, TagHelper::decode(Input::get('tag')))
				->fetchEach('tid');
		}
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

	protected function getContentElementsForArticleTags()
	{
		$hasBackendUser = System::getContainer()->get('contao.security.token_checker')->hasBackendUser();
		$showUnpublished = System::getContainer()->get('contao.security.token_checker')->isPreviewMode();
		$hasFrontendUser = System::getContainer()->get('contao.security.token_checker')->hasFrontendUser();

		$arrArticles = array();
		$ctes = array();
		if (count($this->arrPages) && count($this->arrTags))
		{
			$time = time();
			if (!$hasBackendUser) {
				$arrArticles = Database::getInstance()->prepare("SELECT id FROM tl_article WHERE id IN (" . implode(',', $this->arrTags) . ") AND pid IN (" . implode(',', $this->arrPages) . ") " . " AND (start='' OR start<?) AND (stop='' OR stop>?) AND published=1" . " ORDER BY sorting")
				->execute($time, $time)
				->fetchEach('id');
			} else {
				$arrArticles = Database::getInstance()->prepare("SELECT id FROM tl_article WHERE id IN (" . implode(',', $this->arrTags) . ") AND pid IN (" . implode(',', $this->arrPages) . ") " .  " ORDER BY sorting")
				->execute()
				->fetchEach('id');
			}
			if (count($arrArticles))
			{
				if (!$hasBackendUser) {
					$ctes = Database::getInstance()->prepare("SELECT DISTINCT id, tl_content.* FROM tl_content WHERE pid IN (" . implode(',', $arrArticles) . ") " ." AND invisible<>1" . " ORDER BY sorting")
					->execute()
					->fetchAllAssoc();
				} else {
					$ctes = Database::getInstance()->prepare("SELECT DISTINCT id, tl_content.* FROM tl_content WHERE pid IN (" . implode(',', $arrArticles) . ") " . " ORDER BY sorting")
					->execute()
					->fetchAllAssoc();
				}
			}
		}
		return $ctes;
	}

	protected function getContentElementsForContentTags()
	{
		$hasBackendUser = System::getContainer()->get('contao.security.token_checker')->hasBackendUser();
		$showUnpublished = System::getContainer()->get('contao.security.token_checker')->isPreviewMode();
		$hasFrontendUser = System::getContainer()->get('contao.security.token_checker')->hasFrontendUser();

		$ctes = array();
		if (count($this->arrPages) && count($this->arrTags))
		{
			$time = time();
			if (!$hasBackendUser) {
				$arrArticles = Database::getInstance()->prepare("SELECT id FROM tl_article WHERE pid IN (" . implode(',', $this->arrPages) . ") " ." AND (start='' OR start<?) AND (stop='' OR stop>?) AND published=1". " ORDER BY sorting")
				->execute($time, $time)->fetchEach('id');
			} else {
				$arrArticles = Database::getInstance()->prepare("SELECT id FROM tl_article WHERE pid IN (" . implode(',', $this->arrPages) . ") " . " ORDER BY sorting")
				->execute()->fetchEach('id');
			}
			if (count($arrArticles))
			{
				if (!$hasBackendUser) {
					$ctes = Database::getInstance()->prepare("SELECT DISTINCT id, tl_content.* FROM tl_content WHERE id IN (" . implode(',',$this->arrTags) . ") AND pid IN (" . implode(',',$arrArticles) . ") " . " AND invisible<>1" . " ORDER BY sorting")
					->execute()
					->fetchAllAssoc();
				} else {
					$ctes = Database::getInstance()->prepare("SELECT DISTINCT id, tl_content.* FROM tl_content WHERE id IN (" . implode(',',$this->arrTags) . ") AND pid IN (" . implode(',',$arrArticles) . ") " .  " ORDER BY sorting")
					->execute()
					->fetchAllAssoc();
				}
			}
		}
		return $ctes;
	}

	protected function getArticlesForArticleTags()
	{
		$hasBackendUser = System::getContainer()->get('contao.security.token_checker')->hasBackendUser();
		$showUnpublished = System::getContainer()->get('contao.security.token_checker')->isPreviewMode();
		$hasFrontendUser = System::getContainer()->get('contao.security.token_checker')->hasFrontendUser();

		$articles = array();
		if (count($this->arrPages) && count($this->arrTags))
		{
			$time = time();
			if (!$hasBackendUser) {
				$articles = Database::getInstance()->prepare("SELECT DISTINCT id, tl_article.* FROM tl_article WHERE id IN (" . implode(',',$this->arrTags) . ") AND pid IN (" . implode(',',$this->arrPages) . ") " .  " AND (start='' OR start<?) AND (stop='' OR stop>?) AND published=1". " ORDER BY sorting")
				->execute($time, $time)
				->fetchAllAssoc();
			} else {
				$articles = Database::getInstance()->prepare("SELECT DISTINCT id, tl_article.* FROM tl_article WHERE id IN (" . implode(',',$this->arrTags) . ") AND pid IN (" . implode(',',$this->arrPages) . ") " .  " ORDER BY sorting")
				->execute()
				->fetchAllAssoc();
			}
		}
		return $articles;
	}

	protected function getArticlesForContentTags()
	{
		$hasBackendUser = System::getContainer()->get('contao.security.token_checker')->hasBackendUser();
		$showUnpublished = System::getContainer()->get('contao.security.token_checker')->isPreviewMode();
		$hasFrontendUser = System::getContainer()->get('contao.security.token_checker')->hasFrontendUser();

		$articles = array();
		if (count($this->arrPages) && count($this->arrTags))
		{
			$time = time();
			if (!$hasBackendUser) {
				$arrArticles = Database::getInstance()->prepare("SELECT id FROM tl_article WHERE pid IN (" . implode(',',$this->arrPages) . ") " .  " AND (start='' OR start<?) AND (stop='' OR stop>?) AND published=1" . " ORDER BY sorting")
				->execute($time, $time)->fetchEach('id');
			} else {
				$arrArticles = Database::getInstance()->prepare("SELECT id FROM tl_article WHERE pid IN (" . implode(',',$this->arrPages) . ") " ." ORDER BY sorting")
				->execute()->fetchEach('id');
			}
			if (count($arrArticles))
			{
				if (!$hasBackendUser) {
					$arrContentElements = Database::getInstance()->prepare("SELECT id FROM tl_content WHERE  id IN (" . implode(',',$this->arrTags) . ") AND pid IN (" . implode(',',$arrArticles) . ") " .  " AND invisible<>1"  . " ORDER BY sorting")
					->execute()->fetchEach('id');
				} else {
					$arrContentElements = Database::getInstance()->prepare("SELECT id FROM tl_content WHERE  id IN (" . implode(',',$this->arrTags) . ") AND pid IN (" . implode(',',$arrArticles) . ") " .  " ORDER BY sorting")
					->execute()->fetchEach('id');
				}
				if (count($arrContentElements))
				{
					$articles = Database::getInstance()->prepare("SELECT DISTINCT tl_article.id, tl_article.* FROM tl_article, tl_content WHERE tl_content.id IN (" . implode(',',$arrContentElements) . ") AND tl_content.pid = tl_article.id ORDER BY tl_article.sorting")
						->execute()
						->fetchAllAssoc();
				}
			}
		}
		return $articles;
	}

	protected function getPagesForArticleTags()
	{
		$hasBackendUser = System::getContainer()->get('contao.security.token_checker')->hasBackendUser();
		$showUnpublished = System::getContainer()->get('contao.security.token_checker')->isPreviewMode();
		$hasFrontendUser = System::getContainer()->get('contao.security.token_checker')->hasFrontendUser();

		$pages = array();
		if (count($this->arrPages) && count($this->arrTags))
		{
			$time = time();
			if (!$hasBackendUser) {
				$arrArticles = Database::getInstance()->prepare("SELECT id FROM tl_article WHERE id IN (" . implode(',',$this->arrTags) . ") AND pid IN (" . implode(',',$this->arrPages) . ") " . " AND (start='' OR start<?) AND (stop='' OR stop>?) AND published=1" . " ORDER BY sorting")
				->execute($time, $time)->fetchEach('id');
			} else {
				$arrArticles = Database::getInstance()->prepare("SELECT id FROM tl_article WHERE id IN (" . implode(',',$this->arrTags) . ") AND pid IN (" . implode(',',$this->arrPages) . ") " . " ORDER BY sorting")
				->execute()->fetchEach('id');
			}
			if (count($arrArticles))
			{
				$pages = Database::getInstance()->prepare("SELECT DISTINCT tl_page.id, tl_page.* FROM tl_page, tl_article WHERE tl_article.id IN (" . implode(',',$arrArticles) . ") AND tl_article.pid = tl_page.id ORDER BY tl_page.sorting")
					->execute()->fetchAllAssoc();
			}
		}
		return $pages;
	}

	protected function getPagesForContentTags()
	{
		$hasBackendUser = System::getContainer()->get('contao.security.token_checker')->hasBackendUser();
		$showUnpublished = System::getContainer()->get('contao.security.token_checker')->isPreviewMode();
		$hasFrontendUser = System::getContainer()->get('contao.security.token_checker')->hasFrontendUser();

		$pages = array();
		if (count($this->arrPages) && count($this->arrTags))
		{
			$time = time();
			if (!$hasBackendUser) {
				$arrArticles = Database::getInstance()->prepare("SELECT id FROM tl_article WHERE pid IN (" . implode(',',$this->arrPages) . ") " .  " AND (start='' OR start<?) AND (stop='' OR stop>?) AND published=1" . " ORDER BY sorting")
				->execute($time, $time)->fetchEach('id');
			} else {
				$arrArticles = Database::getInstance()->prepare("SELECT id FROM tl_article WHERE pid IN (" . implode(',',$this->arrPages) . ") " .  " ORDER BY sorting")
				->execute()->fetchEach('id');
			}
			if (count($arrArticles))
			{
				if (!$hasBackendUser) {
					$arrContentElements = Database::getInstance()->prepare("SELECT id FROM tl_content WHERE  id IN (" . implode(',',$this->arrTags) . ") AND pid IN (" . implode(',',$arrArticles) . ") " . " AND invisible<>1". " ORDER BY sorting")
					->execute()->fetchEach('id');
				} else {
					$arrContentElements = Database::getInstance()->prepare("SELECT id FROM tl_content WHERE  id IN (" . implode(',',$this->arrTags) . ") AND pid IN (" . implode(',',$arrArticles) . ") " .  " ORDER BY sorting")
					->execute()->fetchEach('id');
				}
				if (count($arrContentElements))
				{
					$pages = Database::getInstance()->prepare("SELECT DISTINCT tl_page.id, tl_page.* FROM tl_page, tl_article, tl_content WHERE tl_content.id IN (" . implode(',',$arrContentElements) . ") AND tl_content.pid = tl_article.id  AND tl_article.pid = tl_page.id ORDER BY tl_page.sorting")
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
				$this->Template->articles = array();
				$this->Template->pages = array();
				break;
			case 'tl_article':
				$this->Template->contentElements = array();
				$this->Template->articles = $this->getArticles();
				$this->Template->pages = array();
				break;
			case 'tl_page':
				$this->Template->contentElements = array();
				$this->Template->articles = array();
				$this->Template->pages = $this->getPages();
				break;
		}
	}
}

