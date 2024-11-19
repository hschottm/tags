<?php

namespace Hschottm\TagsBundle;

use Contao\System;
use Contao\Module;
use Contao\BackendTemplate;
use Contao\Database;
use Contao\Input;
use Contao\FilesModel;

/**
 * Contao Open Source CMS - tags extension
 *
 * Copyright (c) 2008-2024 Helmut Schottmüller
 *
 * @license LGPL-3.0+
 */

class ModuleTagListByCategory extends Module
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
		$request = System::getContainer()->get('request_stack')->getCurrentRequest();
		if ($request && System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest($request))
		{
			$objTemplate = new BackendTemplate('be_wildcard');
			$objTemplate->wildcard = '### Tag List by Category ###';

			return $objTemplate->parse();
		}
		if (strlen($this->tag_sourcetables)) $this->sourcetables = \Contao\StringUtil::deserialize($this->tag_sourcetables, TRUE);
		\array_push($this->arrPages, $this->pagesource);
		$this->getRelevantPages($this->pagesource);
		return parent::generate();
	}
	
 	/**
	 * Generate module
	 */
	protected function compile()
	{
		$this->loadLanguageFile('tl_module');
		$this->Template->news = array();
		$this->Template->events = array();
		$this->Template->other_pages = array();
		$this->Template->pages = array();
		if (strlen(TagHelper::decode(Input::get('tag'))) && count($this->sourcetables) > 0)
		{
			$tagids = array();
			$tagid_cats = array();
			$relatedlist = (strlen(TagHelper::decode(Input::get('related')))) ? preg_split("/,/", TagHelper::decode(Input::get('related'))) : array();
			$alltags = array_merge(array(TagHelper::decode(Input::get('tag'))), $relatedlist);
			$first = true;
			$marks = array();
			foreach ($this->sourcetables as $table)
			{
				\array_push($marks, $table);
			}
			foreach ($alltags as $tag)
			{
				if (strlen(trim($tag)))
				{
					if (count($tagids))
					{
						$found = Database::getInstance()->prepare("SELECT tid, from_table FROM tl_tag WHERE from_table IN ('" . implode("', '", $marks) . "')" . " AND tag = ? AND tid IN (" . implode(",",$tagids) . ")")
							->execute($tag)
							->fetchAllAssoc();
						foreach ($found as $data)
						{
							\array_push($tagids, $data['tid']);
							if (!array_key_exists($data['from_table'], $tagid_cats)) $tagid_cats[$data['from_table']] = array();
							\array_push($tagid_cats[$data['from_table']], $data['tid']);
						}
					}
					else if ($first)
					{
						$found = Database::getInstance()->prepare("SELECT tid, from_table FROM tl_tag WHERE from_table IN ('" . implode("', '", $marks) . "')" . "  AND tag = ?")
							->execute($tag)
							->fetchAllAssoc();
						foreach ($found as $data)
						{
							\array_push($tagids, $data['tid']);
							if (!array_key_exists($data['from_table'], $tagid_cats)) $tagid_cats[$data['from_table']] = array();
							\array_push($tagid_cats[$data['from_table']], $data['tid']);
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
						if (array_key_exists($sourcetable, $tagid_cats)) {
							$this->Template->news = $this->getNewsForNewsTags($tagid_cats[$sourcetable]);
						} else {
							$this->Template->news = array();
						}
						break;
					case 'tl_calendar_events':
						if (array_key_exists($sourcetable, $tagid_cats)) {
							$this->Template->events = $this->getEventsForEventTags($tagid_cats[$sourcetable]);
						} else {
							$this->Template->events = array();
						}
						break;
					case 'tl_content':
						if (array_key_exists($sourcetable, $tagid_cats)) {
							$pages = array_merge($pages, $this->getPagesForContentTags($tagid_cats[$sourcetable]));
						}
						break;
					case 'tl_article':
						if (array_key_exists($sourcetable, $tagid_cats)) {
							$this->Template->articles = $this->getArticlesForArticleTags($tagid_cats[$sourcetable]);
							$pages = array_merge($pages, $this->getPagesForArticleTags($tagid_cats[$sourcetable]));
						} else {
							$this->Template->articles = array();
						}
						break;
					default:
						if (isset($GLOBALS['TL_HOOKS']['tagSourceTable']) && is_array($GLOBALS['TL_HOOKS']['tagSourceTable'])) {
							$arrTagTemplates = array();
							foreach ($GLOBALS['TL_HOOKS']['tagSourceTable'] as $type => $callback) {
								$this->import($callback[0]);
								$arrTagTemplates = array_merge($arrTagTemplates,$this->$callback[0]->$callback[1]($sourcetable,$tagid_cats[$sourcetable]));
							}
							$this->Template->other_pages = $arrTagTemplates;
						}
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

	protected function getNewsForNewsTags($tagids)
	{
		$hasBackendUser = System::getContainer()->get('contao.security.token_checker')->hasBackendUser();
		$showUnpublished = System::getContainer()->get('contao.security.token_checker')->isPreviewMode();
		$hasFrontendUser = System::getContainer()->get('contao.security.token_checker')->hasFrontendUser();

		$time = time();
		if (count($tagids))
		{
			if (!$hasBackendUser) {
				$objArticles = Database::getInstance()->prepare("SELECT *, author AS authorId, (SELECT title FROM tl_news_archive WHERE tl_news_archive.id=tl_news.pid) AS archive, (SELECT jumpTo FROM tl_news_archive WHERE tl_news_archive.id=tl_news.pid) AS parentJumpTo, (SELECT name FROM tl_user WHERE id=author) AS author FROM tl_news WHERE id IN (" . implode(",",$tagids) . ")" . " AND (start='' OR start<$time) AND (stop='' OR stop>$time) AND published=1". " ORDER BY date DESC");
			} else {
				$objArticles = Database::getInstance()->prepare("SELECT *, author AS authorId, (SELECT title FROM tl_news_archive WHERE tl_news_archive.id=tl_news.pid) AS archive, (SELECT jumpTo FROM tl_news_archive WHERE tl_news_archive.id=tl_news.pid) AS parentJumpTo, (SELECT name FROM tl_user WHERE id=author) AS author FROM tl_news WHERE id IN (" . implode(",",$tagids) . ")" . " ORDER BY date DESC");
			}

			$objects = $objArticles->execute()->fetchAllAssoc();

			$i = 0;
			foreach($objects as $object){
				if($object['addImage'] == "1"){
					$objPath = FilesModel::findByUuid($object['singleSRC']);
					$objects[$i]['imageUrl'] = $objPath->path;
				}
				$i++;
			}

			return $objects;
		}
		else
		{
			return array();
		}
	}

	protected function getEventsForEventTags($tagids)
	{
		$hasBackendUser = System::getContainer()->get('contao.security.token_checker')->hasBackendUser();
		$showUnpublished = System::getContainer()->get('contao.security.token_checker')->isPreviewMode();
		$hasFrontendUser = System::getContainer()->get('contao.security.token_checker')->hasFrontendUser();

		$time = time();
		if (count($tagids))
		{
			if (!$hasBackendUser) {
				$objEvents = Database::getInstance()->prepare("SELECT *, (SELECT name FROM tl_user WHERE id=author) author FROM tl_calendar_events WHERE id IN (" . implode(",",$tagids) . ") " .  " AND (start='' OR start<$time) AND (stop='' OR stop>$time) AND published=1" . " ORDER BY startTime")
				->execute();
			} else {
				$objEvents = Database::getInstance()->prepare("SELECT *, (SELECT name FROM tl_user WHERE id=author) author FROM tl_calendar_events WHERE id IN (" . implode(",",$tagids) . ") " .  " ORDER BY startTime")
				->execute();
			}
			return $objEvents->fetchAllAssoc();
		}
		else
		{
			return array();
		}
	}

	protected function getPagesForArticleTags($tags)
	{
		$hasBackendUser = System::getContainer()->get('contao.security.token_checker')->hasBackendUser();
		$showUnpublished = System::getContainer()->get('contao.security.token_checker')->isPreviewMode();
		$hasFrontendUser = System::getContainer()->get('contao.security.token_checker')->hasFrontendUser();

		$pages = array();
		if (count($this->arrPages) && count($tags))
		{
			$time = time();
			if (!$hasBackendUser) {
				$arrArticles = Database::getInstance()->prepare("SELECT id FROM tl_article WHERE id IN (" . implode(',',$tags) . ") AND pid IN (" . implode(',',$this->arrPages) . ") " .  " AND (start='' OR start<?) AND (stop='' OR stop>?) AND published=1"  . " ORDER BY sorting")
				->execute($time, $time)->fetchEach('id');
			} else {
				$arrArticles = Database::getInstance()->prepare("SELECT id FROM tl_article WHERE id IN (" . implode(',',$tags) . ") AND pid IN (" . implode(',',$this->arrPages) . ") " .  " ORDER BY sorting")
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

	protected function getArticlesForArticleTags($tags)
	{
		$hasBackendUser = System::getContainer()->get('contao.security.token_checker')->hasBackendUser();
		$showUnpublished = System::getContainer()->get('contao.security.token_checker')->isPreviewMode();
		$hasFrontendUser = System::getContainer()->get('contao.security.token_checker')->hasFrontendUser();

		$articles = array();
		if (count($this->arrPages) && count($tags))
		{
			$time = time();
			if (!$hasBackendUser) {
				$articles = Database::getInstance()->prepare("SELECT DISTINCT id, tl_article.* FROM tl_article WHERE id IN (" . implode(',',$tags) . ") AND pid IN (" . implode(',',$this->arrPages) . ") " . " AND (start='' OR start<?) AND (stop='' OR stop>?) AND published=1". " ORDER BY sorting")
				->execute($time, $time)
				->fetchAllAssoc();
			} else {
				$articles = Database::getInstance()->prepare("SELECT DISTINCT id, tl_article.* FROM tl_article WHERE id IN (" . implode(',',$tags) . ") AND pid IN (" . implode(',',$this->arrPages) . ") " . " ORDER BY sorting")
				->execute()
				->fetchAllAssoc();
			}
		}
		return $articles;
	}

	protected function getPagesForContentTags($tags)
	{
		$hasBackendUser = System::getContainer()->get('contao.security.token_checker')->hasBackendUser();
		$showUnpublished = System::getContainer()->get('contao.security.token_checker')->isPreviewMode();
		$hasFrontendUser = System::getContainer()->get('contao.security.token_checker')->hasFrontendUser();

		$pages = array();
		if (count($this->arrPages) && count($tags))
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
					$arrContentElements = Database::getInstance()->prepare("SELECT id FROM tl_content WHERE  id IN (" . implode(',',$tags) . ") AND pid IN (" . implode(',',$arrArticles) . ") " ." AND invisible<>1" . " ORDER BY sorting")
					->execute()->fetchEach('id');
				} else {
					$arrContentElements = Database::getInstance()->prepare("SELECT id FROM tl_content WHERE  id IN (" . implode(',',$tags) . ") AND pid IN (" . implode(',',$arrArticles) . ") " .  " ORDER BY sorting")
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
}

