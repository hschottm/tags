<?php

namespace Contao;

/**
 * @copyright  Helmut Schottmüller 2009-2013
 * @author     Helmut Schottmüller <https://github.com/hschottm>
 * @package    Frontend
 * @license    LGPL
 * @filesource
 */


/**
 * Class ModuleTaggedArticleList
 *
 * Front end module "tagged article list".
 * @copyright  Helmut Schottmüller 2009-2013
 * @author     Helmut Schottmüller <https://github.com/hschottm>
 * @package    Controller
 */
class ModuleTaggedArticleList extends \ModuleGlobalArticlelist
{
	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_global_articlelist';
	protected $arrPages = array();
	protected $arrArticles = array();


	/**
	 * Do not display the module if there are no articles
	 * @return string
	 */
	public function generate()
	{
		if (TL_MODE == 'BE')
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
				array_push($orders, 'start ' . $GLOBALS['MISC']['tag_articles_id'][$this->id]['ORDER_BY_START'] . ', title ASC');
			}
			if (strlen($this->articlelist_firstorder))
			{
				array_push($orders, $this->articlelist_firstorder);
			}
			if (strlen($this->articlelist_secondorder))
			{
				array_push($orders, $this->articlelist_secondorder);
			}
			$order_by = '';
			if (count($orders))
			{
				$order_by = ' ORDER BY ' . implode(', ', $orders);
			}

			if ($this->show_in_column)
			{
				$objArticles = $this->Database->prepare("SELECT id, pid, title, alias, inColumn, cssID, teaser, start FROM tl_article WHERE inColumn = ? AND pid IN (" . $pids . ") " . (!BE_USER_LOGGED_IN ? " AND (start='' OR start<?) AND (stop='' OR stop>?) AND published=1" : "") . $order_by)
											  ->execute($this->inColumn, $time, $time);
			}
			else
			{
				$objArticles = $this->Database->prepare("SELECT id, pid, title, alias, inColumn, cssID, teaser, start FROM tl_article WHERE pid IN (" . $pids . ") " . (!BE_USER_LOGGED_IN ? " AND (start='' OR start<?) AND (stop='' OR stop>?) AND published=1" : "") . $order_by)
											  ->execute($time, $time);
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

				$objArticles->cssID = deserialize($objArticles->cssID, true);
				// ??? $alias = strlen($objArticles->alias) ? $objArticles->alias : $objArticles->title;
				$objArticles->startDate = (intval($objArticles->start) > 0) ? $this->parseDate($GLOBALS['TL_CONFIG']['datimFormat'], intval($objArticles->start)) : '';
				$objArticles->teaser = $this->replaceInsertTags($objArticles->teaser);
				if (!empty($format))
				{
					if ($format == 'xhtml')
					{
						$objArticles->teaser = StringUtil::toXhtml($objArticles->teaser);
					}
					else
					{
						$objArticles->teaser = StringUtil::toHtml5($objArticles->teaser);
					}
				}

				array_push($this->arrArticles, $objArticles->row());
			}
		}
	}

	/**
	 * Read tags from database
	 * @return string
	 */
	protected function getTags($id)
	{
		$tags = $this->Database->prepare("SELECT tag FROM tl_tag WHERE tid = ? AND from_table = ? ORDER BY tag ASC")
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
		if ($this->Session->get('block'))
		{
			$this->Session->set('block', false);
			return;
		}
		$this->Session->set('block', true);
		$articles = array();
		$id = $objPage->id;

		$this->Template->request = $this->Environment->request;

		$time = time();

		if (strlen($this->tag_articles)) $arrArticles = deserialize($this->tag_articles, TRUE);
		array_push($this->arrPages, $arrArticles[0]);
		$this->getRelevantPages($arrArticles[0]);
		$this->getArticlesForPages();

		$tagids = array();

		$relatedlist = (strlen($this->Input->get('related'))) ? preg_split("/,/", $this->Input->get('related')) : array();
		$alltags = array_merge(array($this->Input->get('tag')), $relatedlist);
		$first = true;
		foreach ($alltags as $tag)
		{
			if (strlen(trim($tag)))
			{
				if (count($tagids))
				{
					$tagids = $this->Database->prepare("SELECT tid FROM tl_tag WHERE from_table = ? AND tag = ? AND tid IN (" . join($tagids, ",") . ")")
						->execute('tl_article', $tag)
						->fetchEach('tid');
				}
				else if ($first)
				{
					$tagids = $this->Database->prepare("SELECT tid FROM tl_tag WHERE from_table = ? AND tag = ?")
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
							$objPageJumpTo = $this->Database->prepare("SELECT id, alias FROM tl_page WHERE id=?")
								->limit(1)
								->execute($this->tag_jumpTo);
							$pageArr = ($objPageJumpTo->numRows) ? $objPageJumpTo->fetchAssoc() : array();
						}
						if (count($pageArr) == 0)
						{
							$items = '';
							if (strlen($this->Input->get('items')))
							{
								$items = '/items/' . $this->Input->get('items');
							}
							$pageArr = $objPage->row();
						}
						$tags = $this->getTags($arrArticle['id']);
						foreach ($tags as $id => $tag)
						{
							$strUrl = ampersand($this->generateFrontendUrl($pageArr, $items . '/tag/' . \System::urlencode($tag)));
							$tags[$id] = '<a href="' . $strUrl . '">' . specialchars($tag) . '</a>';
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
		if (strlen($this->Input->get('tag')))
		{
			$relatedlist = (strlen($this->Input->get('related'))) ? preg_split("/,/", $this->Input->get('related')) : array();
			$headlinetags = array_merge(array($this->Input->get('tag')), $relatedlist);
		}
		$this->Template->showTags = $this->article_showtags;
		$this->Template->tags_activetags = $headlinetags;
		$this->Template->articles = $articles;
		$this->Template->empty = $GLOBALS['TL_LANG']['MSC']['emptyarticles'];
		$this->Session->set('block', false);
	}
}
