<?php

namespace Hschottm\TagsBundle;

use Contao\Module;
use Contao\Database;
use Contao\System;
use Contao\Environment;
use Contao\BackendTemplate;
use Contao\Input;

/**
 * Contao Open Source CMS - tags extension
 *
 * Copyright (c) 2008-2024 Helmut Schottmüller
 *
 * @license LGPL-3.0+
 */

class ModuleGlobalArticlelist extends Module
{
	private $block = false;


	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_global_articlelist';


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
			$objTemplate->wildcard = '### GLOBAL ARTICLE LIST ###';

			return $objTemplate->parse();
		}

		$this->strTemplate = (strlen($this->articlelist_template)) ? $this->articlelist_template : $this->strTemplate;
		return parent::generate();
	}


	/**
	 * Generate module
	 */
	protected function compile()
	{
		global $objPage;

		$hasBackendUser = System::getContainer()->get('contao.security.token_checker')->hasBackendUser();
		$showUnpublished = System::getContainer()->get('contao.security.token_checker')->isPreviewMode();
		$hasFrontendUser = System::getContainer()->get('contao.security.token_checker')->hasFrontendUser();

		// block this method to prevent recursive call of getArticle if the HTML of an article is the same as the current article
		if ($this->block)
		{
			$this->block = false;
			return;
		}
		$this->block = true;
		$articles = array();
		$id = $objPage->id;

		$this->Template->request = Environment::get('request');

		$time = time();

		// Get published articles
		if (!$hasBackendUser) {
			$objArticles = Database::getInstance()->prepare("SELECT id, title, inColumn, cssID FROM tl_article" ." WHERE (start='' OR start<?) AND (stop='' OR stop>?) AND published=1" . " ORDER BY title")
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
			$cssID = \Contao\StringUtil::deserialize($objArticles->cssID, true);

			$objArticle = Database::getInstance()->prepare("SELECT a.id AS aId, a.alias AS aAlias, a.title AS title, p.id AS id, p.alias AS alias, a.teaser FROM tl_article a, tl_page p WHERE a.pid=p.id AND (a.id=? OR a.alias=?)")
										 ->limit(1)
										 ->execute($objArticles->id, $objArticles->id);

			if ($objArticle->numRows)
			{
				if (count($tagids) || !$this->hide_on_empty)
				{
					if (in_array($objArticle->aId, $tagids) || (!$this->hide_on_empty && count($tagids) == 0))
					{
						$objTeaser = Database::getInstance()->prepare("SELECT teaser FROM tl_article WHERE id=? OR alias=?")
													->limit(1)
													->execute((is_numeric($objArticle->aId) ? $objArticle->aId : 0), $objArticle->alias);
						$teaser = '';
						if ($objTeaser->numRows)
						{
							$teaser = $objTeaser->teaser;
						}
						if ($this->linktoarticles)
						{ // link to articles
							$articles[] = array('content' => '{{article::' . $objArticle->aId . '}}', 'url' => '{{article_url::' . $objArticle->aId . '}}', 'tags' => '{{tags_article::' . $objArticle->aId . '}}', 'data' => $objArticle->row(), 'html' => $this->getArticle($objArticle->aId, false, true), 'teaser' => $teaser);
						}
						else
						{ // link to pages
							$articles[] = array('content' => '{{link::' . $objArticle->id . '}}', 'url' => '{{link_url::' . $objArticle->id . '}}', 'tags' => '{{tags_article::' . $objArticle->aId . '}}', 'data' => $objArticle->row(), 'html' => $this->getArticle($objArticle->aId, false, true), 'teaser' => $teaser);
						}
					}
				}
			}
		}
		$headlinetags = array();
		if (strlen(TagHelper::decode(Input::get('tag'))))
		{
			$relatedlist = (strlen(TagHelper::decode(Input::get('related')))) ? preg_split("/,/", TagHelper::decode(Input::get('related'))) : array();
			$headlinetags = array_merge(array(TagHelper::decode(Input::get('tag'))), $relatedlist);
		}
		$this->Template->tags_activetags = $headlinetags;
		$this->Template->articles = $articles;
		$this->Template->empty = $GLOBALS['TL_LANG']['MSC']['emptyarticles'];
		$this->block = false;
	}
}

