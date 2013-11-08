<?php

/**
 * @copyright  Helmut Schottmüller 2009
 * @author     Helmut Schottmüller <typolight@aurealis.de>
 * @package    News
 * @license    LGPL
 * @filesource
 */

namespace Contao;

if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Class ModuleNewsListTags
 *
 * Front end module "news list".
 * @copyright  Helmut Schottmüller 2009
 * @author     Helmut Schottmüller <typolight@aurealis.de>
 * @package    Controller
 */
class ModuleNewsListTags extends \ModuleNewsList
{
	/**
	 * Display a wildcard in the back end
	 * @return string
	 */
	public function generate()
	{
		return parent::generate();
	}

	/**
	 * Read tags from database
	 * @return string
	 */
	protected function getFilterTags()
	{
		if (strlen($this->tag_filter))
		{
			$tags = preg_split("/,/", $this->tag_filter);
			$placeholders = array();
			foreach ($tags as $tag)
			{
				array_push($placeholders, '?');
			}
			array_push($tags, 'tl_news');
			return $this->Database->prepare("SELECT tid FROM tl_tag WHERE tag IN (" . join($placeholders, ',') . ") AND from_table = ? ORDER BY tag ASC")
				->execute($tags)
				->fetchEach('tid');
		}
		else
		{
			return array();
		}
	}

	/**
	 * Generate the module
	 */
	protected function compileFromParent($arrIds)
	{
		$offset = intval($this->skipFirst);
		$limit = null;
		$this->Template->articles = array();

		// Maximum number of items
		if ($this->numberOfItems > 0)
		{
			$limit = $this->numberOfItems;
		}

		// Handle featured news
		if ($this->news_featured == 'featured')
		{
			$blnFeatured = true;
		}
		elseif ($this->news_featured == 'unfeatured')
		{
			$blnFeatured = false;
		}
		else
		{
			$blnFeatured = null;
		}

		// Get the total number of items
		$intTotal = \TagsNewsModel::countPublishedByPidsAndIds($this->news_archives, $arrIds, $blnFeatured);

		if ($intTotal < 1)
		{
			$this->Template->articles = array();
			return;
		}

		$total = $intTotal - $offset;

		// Split the results
		if ($this->perPage > 0 && (!isset($limit) || $this->numberOfItems > $this->perPage))
		{
			// Adjust the overall limit
			if (isset($limit))
			{
				$total = min($limit, $total);
			}

			// Get the current page
			$id = 'page_n' . $this->id;
			$page = \Input::get($id) ?: 1;

			// Do not index or cache the page if the page number is outside the range
			if ($page < 1 || $page > max(ceil($total/$this->perPage), 1))
			{
				global $objPage;
				$objPage->noSearch = 1;
				$objPage->cache = 0;

				// Send a 404 header
				header('HTTP/1.1 404 Not Found');
				return;
			}

			// Set limit and offset
			$limit = $this->perPage;
			$offset += (max($page, 1) - 1) * $this->perPage;

			// Overall limit
			if ($offset + $limit > $total)
			{
				$limit = $total - $offset;
			}

			// Add the pagination menu
			$objPagination = new \Pagination($total, $this->perPage, 7, $id);
			$this->Template->pagination = $objPagination->generate("\n  ");
		}

		// Get the items
		if (isset($limit))
		{
			$objArticles = \TagsNewsModel::findPublishedByPidsAndIds($this->news_archives, $arrIds, $blnFeatured, $limit, $offset);
		}
		else
		{
			$objArticles = \TagsNewsModel::findPublishedByPidsAndIds($this->news_archives, $arrIds, $blnFeatured, 0, $offset);
		}

		// No items found
		if ($objArticles === null)
		{
			$this->Template = new \FrontendTemplate('mod_newsarchive_empty');
		}
		else
		{
			$this->Template->articles = $this->parseArticles($objArticles);
		}

		// new code for tags
		$relatedlist = (strlen(\Input::get('related'))) ? preg_split("/,/", \Input::get('related')) : array();
		$headlinetags = array();
		if (strlen(\Input::get('tag')))
		{
			$headlinetags = array_merge($headlinetags, array(\Input::get('tag')));
			if (count($relatedlist))
			{
				$headlinetags = array_merge($headlinetags, $relatedlist);
			}
		}
		$this->Template->tags_total_found = $intTotal;
		$this->Template->tags_activetags = $headlinetags;
	}

	/**
	 * Generate module
	 */
	protected function compile()
	{
		$this->Session->set('news_showtags', $this->news_showtags);
		$this->Session->set('news_jumpto', $this->tag_jumpTo);
		$this->Session->set('news_tag_named_class', $this->tag_named_class);
		if ((strlen(\Input::get('tag')) && (!$this->tag_ignore)) || (strlen($this->tag_filter)))
		{
			$tagids = array();
			
			$relatedlist = (strlen(\Input::get('related'))) ? preg_split("/,/", \Input::get('related')) : array();
			$alltags = array_merge(array(\Input::get('tag')), $relatedlist);
			$first = true;
			if (strlen($this->tag_filter))
			{
				$headlinetags = preg_split("/,/", $this->tag_filter);
				$tagids = $this->getFilterTags();
				$first = false;
			}
			else
			{
				$headlinetags = array();
			}
			foreach ($alltags as $tag)
			{
				if (strlen(trim($tag)))
				{
					if (count($tagids))
					{
						$tagids = $this->Database->prepare("SELECT tid FROM tl_tag WHERE from_table = ? AND tag = ? AND tid IN (" . join($tagids, ",") . ")")
							->execute('tl_news', $tag)
							->fetchEach('tid');
					}
					else if ($first)
					{
						$tagids = $this->Database->prepare("SELECT tid FROM tl_tag WHERE from_table = ? AND tag = ?")
							->execute('tl_news', $tag)
							->fetchEach('tid');
						$first = false;
					}
				}
			}
			if (count($tagids))
			{
				$this->compileFromParent($tagids);
			}
			else
			{
				parent::compile();
			}
		}
		else
		{
			parent::compile();
		}
		$this->Session->set('news_showtags', '');
		$this->Session->set('news_jumpto', '');
		$this->Session->set('news_tag_named_class', '');
	}
}

?>