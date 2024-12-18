<?php

namespace Hschottm\TagsBundle;

use Contao\Database;
use Contao\System;
use Contao\Module;
use Contao\Environment;
use Contao\BackendTemplate;
use Contao\FrontendTemplate;
use Contao\Input;
use Contao\StringUtil;
use Contao\PageModel;
use Contao\CoreBundle\Routing\ContentUrlGenerator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * @copyright  Helmut Schottmüller 2009-2024
 * @author     Helmut Schottmüller <https://github.com/hschottm>
 * @package    Frontend
 * @license    LGPL
 * @filesource
 */


/**
 * Class ModuleTaggedArticleList
 *
 * Front end module "tagged article list".
 * @copyright  Helmut Schottmüller 2009-2024
 * @author     Helmut Schottmüller <https://github.com/hschottm>
 * @package    Controller
 */
class ModuleTaggedArticleList extends ModuleGlobalArticlelist
{
	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_global_articlelist';
	protected $arrPages = array();
	protected $arrArticles = array();

	private $block = false;

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
			$objTemplate->wildcard = '### TAGGED ARTICLE LIST ###';

			return $objTemplate->parse();
		}

		$this->strTemplate = (strlen($this->articlelist_tpl)) ? $this->articlelist_tpl : $this->strTemplate;
		$this->articlelist_template = $this->strTemplate;

		return parent::generate();
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
		$hasBackendUser = System::getContainer()->get('contao.security.token_checker')->hasBackendUser();
		$showUnpublished = System::getContainer()->get('contao.security.token_checker')->isPreviewMode();
		$hasFrontendUser = System::getContainer()->get('contao.security.token_checker')->hasFrontendUser();

		$this->arrArticles = array();
		if (count($this->arrPages))
		{
			$time = time();

			// Get published articles
			$pids = implode(",",$this->arrPages);

			$orders = array();
			if (isset($GLOBALS['MISC']['tag_articles_id'][$this->id]['ORDER_BY_START'])
				&& in_array($GLOBALS['MISC']['tag_articles_id'][$this->id]['ORDER_BY_START'], array('ASC', 'DESC')))
			{
				// Use the 'start' field (Anzeigen ab/Show from) for sorting (interpret it as an article creation/publishing date).
				// Instead of a backend field in the module, look for the setting in localconfig.php.
				// If you use this (hidden) feature you probably also might want to add the following 2 lines to dcaconfig.php,
				// making the start field mandatory (in the DCA, not the DB).
				//   $GLOBALS['TL_DCA']['tl_article']['fields']['start']['eval']['mandatory'] = true;
				//   $GLOBALS['TL_DCA']['tl_article']['fields']['start']['default'] = time();
				// Note however, after creating a new page, you still have to set the article start date explicitly, because the Contao core
				// auto inserts an article for you and doesn't check for mandatory fields. As soon as you edit the article settings,
				// e.g. to add tags :) you'll be forced to also fill in the 'start' field.
				\array_push($orders, 'start ' . $GLOBALS['MISC']['tag_articles_id'][$this->id]['ORDER_BY_START'] . ', title ASC');
			}
			if (strlen($this->articlelist_firstorder))
			{
				\array_push($orders, $this->articlelist_firstorder);
			}
			if (strlen($this->articlelist_secondorder))
			{
				\array_push($orders, $this->articlelist_secondorder);
			}
			$order_by = '';
			if (count($orders))
			{
				$order_by = ' ORDER BY ' . implode(', ', $orders);
			}

			if ($this->show_in_column)
			{
				if (!$hasBackendUser) {
					$objArticles = Database::getInstance()->prepare("SELECT id, pid, title, alias, inColumn, cssID, teaser, start FROM tl_article WHERE inColumn = ? AND pid IN (" . $pids . ") " . " AND (start='' OR start<?) AND (stop='' OR stop>?) AND published=1"  . $order_by)
					->execute($this->inColumn, $time, $time);
} else {
	$objArticles = Database::getInstance()->prepare("SELECT id, pid, title, alias, inColumn, cssID, teaser, start FROM tl_article WHERE inColumn = ? AND pid IN (" . $pids . ") " .  $order_by)
	->execute($this->inColumn);
}
			}
			else
			{
				if (!$hasBackendUser) {
					$objArticles = Database::getInstance()->prepare("SELECT id, pid, title, alias, inColumn, cssID, teaser, start FROM tl_article WHERE pid IN (" . $pids . ") " . " AND (start='' OR start<?) AND (stop='' OR stop>?) AND published=1" . $order_by)
					->execute($time, $time);
} else {
	$objArticles = Database::getInstance()->prepare("SELECT id, pid, title, alias, inColumn, cssID, teaser, start FROM tl_article WHERE pid IN (" . $pids . ") " . $order_by)
	->execute();
}
			}
			if ($objArticles->numRows < 1)
			{
				return;
			}

			global $objPage;
			$format = $objPage->outputFormat;

			while ($objArticles->next())
			{
				/* This code seems to be a useless "left over copy/paste" from an old version of system/modules/frontend/ModuleArticleList.php
				// Skip first article
				if (++$intCount == 1 && $this->skipFirst)
				{
					continue;
				}
				*/

				$objArticles->cssID = StringUtil::deserialize($objArticles->cssID, true);
				// ??? $alias = strlen($objArticles->alias) ? $objArticles->alias : $objArticles->title;
				$objArticles->startDate = (intval($objArticles->start) > 0) ? $this->parseDate($GLOBALS['TL_CONFIG']['datimFormat'], intval($objArticles->start)) : '';
				$teaser = $objArticles->teaser;
				if (isset($teaser)) {
					$insertTagParser = System::getContainer()->get('contao.insert_tag.parser');
					$teaser = $insertTagParser->replace($teaser);
				}
				if (!empty($format))
				{
					if ($format == 'xhtml')
					{
						$objArticles->teaser = StringUtil::toXhtml($teaser);
					}
					else
					{
						$objArticles->teaser = StringUtil::toHtml5($teaser);
					}
				}

				\array_push($this->arrArticles, $objArticles->row());
			}
		}
	}

	/**
	 * Read tags from database
	 * @return string
	 */
	protected function getTags($id)
	{
		$tags = Database::getInstance()->prepare("SELECT tag FROM tl_tag WHERE tid = ? AND from_table = ? ORDER BY tag ASC")
			->execute($id, 'tl_article')
			->fetchEach('tag');
		return $tags;
	}

	/**
	 * Generate module
	 */
	protected function compile()
	{
		global $objPage;

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

		if (strlen($this->tag_articles)) $arrArticles = StringUtil::deserialize($this->tag_articles, TRUE);
		\array_push($this->arrPages, $arrArticles[0]);
		$this->getRelevantPages($arrArticles[0]);
		$this->getArticlesForPages();

		$tagids = array();

		$relatedlist = (strlen(TagHelper::decode(Input::get('related')))) ? preg_split("/,/", TagHelper::decode(Input::get('related'))) : array();
		$alltags = array_merge(array(TagHelper::decode(Input::get('tag'))), $relatedlist);
		$first = true;
		foreach ($alltags as $tag)
		{
			if (strlen(trim($tag)))
			{
				if (count($tagids))
				{
					$tagids = Database::getInstance()->prepare("SELECT tid FROM tl_tag WHERE from_table = ? AND tag = ? AND tid IN (" . implode(",",$tagids) . ")")
						->execute('tl_article', $tag)
						->fetchEach('tid');
				}
				else if ($first)
				{
					$tagids = Database::getInstance()->prepare("SELECT tid FROM tl_tag WHERE from_table = ? AND tag = ?")
						->execute('tl_article', $tag)
						->fetchEach('tid');
					$first = false;
				}
			}
		}

		foreach ($this->arrArticles as $arrArticle)
		{
			if (count($tagids) || !$this->hide_on_empty)
			{
				if (in_array($arrArticle['id'], $tagids) || (!$this->hide_on_empty && count($tagids) == 0))
				{
					$objTemplate = new FrontendTemplate('taglist');
					$objTemplate->showTags = $this->article_showtags;
					$taglist = '';
					if ($this->article_showtags)
					{
						$pageArr = array();
						if (strlen($this->tag_jumpTo))
						{
							$objPageJumpTo = Database::getInstance()->prepare("SELECT id, alias FROM tl_page WHERE id=?")
								->limit(1)
								->execute($this->tag_jumpTo);
							$pageArr = ($objPageJumpTo->numRows) ? $objPageJumpTo->fetchAssoc() : array();
						}
						if (count($pageArr) == 0)
						{
							$items = '';
							if (strlen(Input::get('items')))
							{
								$items = '/items/' . Input::get('items');
							}
							$pageArr = $objPage->row();
						}
						$tags = $this->getTags($arrArticle['id']);
						//$contentUrlGenerator = System::getContainer()->get('contao.routing.content_url_generator');
						foreach ($tags as $id => $tag)
						{
							//$pageModel = PageModel::findPublishedByIdOrAlias("48");
							//$strUrl = StringUtil::ampersand($pageModel->getFrontendUrl('/tag/' . TagHelper::encode($tag['tag_name'])));
							$strUrl = '{{article_url::' . $arrArticle['id'] . '}}';
							$tags[$id] = '<a href="' . $strUrl . '">' . StringUtil::specialchars($tag) . '</a>';
						}
						$objTemplate->tags = $tags;
						$taglist = $objTemplate->parse();
					}

					if ($this->linktoarticles)
					{ // link to articles
						$articles[] = array('content' => '{{article::' . $arrArticle['id'] . '}}', 'url' => '{{article_url::' . $arrArticle['id'] . '}}', 'tags' => $taglist, 'data' => $arrArticle, 'html' => $this->getArticle($arrArticle['id'], false, true), 'teaser' => $arrArticle['teaser']);
					}
					else
					{ // link to pages
						$articles[] = array('content' => '{{link::' . $arrArticle['pid'] . '}}', 'url' => '{{link_url::' . $arrArticle['pid'] . '}}', 'tags' => $taglist, 'data' => $arrArticle, 'html' => $this->getArticle($arrArticle['id'], false, true), 'teaser' => $arrArticle['teaser']);
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
		$this->Template->showTags = $this->article_showtags;
		$this->Template->tags_activetags = $headlinetags;
		$this->Template->articles = $articles;
		$this->Template->empty = $GLOBALS['TL_LANG']['MSC']['emptyarticles'];
		$this->block = false;
	}
}
