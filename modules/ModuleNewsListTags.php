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
			return $this->Database->prepare("SELECT id FROM tl_tag WHERE tag IN (" . join($placeholders, ',') . ") AND from_table = ? ORDER BY tag ASC")
				->execute($tags)
				->fetchEach('id');
		}
		else
		{
			return array();
		}
	}

	/**
	 * Generate module
	 */
	protected function compile()
	{
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
						$tagids = $this->Database->prepare("SELECT id FROM tl_tag WHERE from_table = ? AND tag = ? AND id IN (" . join($tagids, ",") . ")")
							->execute('tl_news', $tag)
							->fetchEach('id');
					}
					else if ($first)
					{
						$tagids = $this->Database->prepare("SELECT id FROM tl_tag WHERE from_table = ? AND tag = ?")
							->execute('tl_news', $tag)
							->fetchEach('id');
						$first = false;
					}
				}
			}

			$time = time();
			$skipFirst = intval($this->skipFirst);
			$offset = 0;
			$limit = null;

			// Maximum number of items
			if ($this->news_numberOfItems > 0)
			{
				$limit = $this->news_numberOfItems;
			}

			$total = 0;
			if (count($tagids))
			{
				// Get the total number of items
				$objTotal = $this->Database->execute("SELECT COUNT(*) total FROM tl_news WHERE pid IN(" . implode(',', array_map('intval', $this->news_archives)) . ")" . (($this->news_featured == 'featured') ? " AND featured=1" : (($this->news_featured == 'unfeatured') ? " AND featured=''" : "")) ." AND id IN (" . join($tagids, ",") . ")" . (!BE_USER_LOGGED_IN ? " AND (start='' OR start<$time) AND (stop='' OR stop>$time) AND published=1" : "") . " ORDER BY date DESC");
				$total = $objTotal->total - $skipFirst;

				// Split the results
				if ($this->perPage > 0 && (!isset($limit) || $this->news_numberOfItems > $this->perPage))
				{
					// Adjust the overall limit
					if (isset($limit))
					{
						$total = min($limit, $total);
					}

					$page = \Input::get('page') ? \Input::get('page') : 1;

					// Check the maximum page number
					if ($page > ($total/$this->perPage))
					{
						$page = ceil($total/$this->perPage);
					}

					// Limit and offset
					$limit = $this->perPage;
					$offset = ($page - 1) * $this->perPage;

					// Overall limit
					if ($offset + $limit > $total)
					{
						$limit = $total - $offset;
					}

					// Add the pagination menu
					$objPagination = new Pagination($total, $this->perPage);
					$this->Template->pagination = $objPagination->generate("\n  ");
				}

				$objArticlesCount = $this->Database->execute("SELECT author FROM tl_news WHERE pid IN(" . implode(',', array_map('intval', $this->news_archives)) . ")" . (($this->news_featured == 'featured') ? " AND featured=1" : (($this->news_featured == 'unfeatured') ? " AND featured=''" : "")) ." AND id IN (" . join($tagids, ",") . ")" . (!BE_USER_LOGGED_IN ? " AND (start='' OR start<$time) AND (stop='' OR stop>$time) AND published=1" : "") . " ORDER BY date DESC");
				$totalfound = $objArticlesCount->numRows;
				$objArticles = $this->Database->prepare("SELECT *, author AS authorId, (SELECT title FROM tl_news_archive WHERE tl_news_archive.id=tl_news.pid) AS archive, (SELECT jumpTo FROM tl_news_archive WHERE tl_news_archive.id=tl_news.pid) AS parentJumpTo, (SELECT name FROM tl_user WHERE id=author) AS author FROM tl_news WHERE pid IN(" . implode(',', array_map('intval', $this->news_archives)) . ")" . (($this->news_featured == 'featured') ? " AND featured=1" : (($this->news_featured == 'unfeatured') ? " AND featured=''" : "")) ." AND id IN (" . join($tagids, ",") . ")" . (!BE_USER_LOGGED_IN ? " AND (start='' OR start<$time) AND (stop='' OR stop>$time) AND published=1" : "") . " ORDER BY date DESC");

				// Limit the result
				if (isset($limit))
				{
					$objArticles->limit($limit, $offset + $skipFirst);
				}
				elseif ($skipFirst > 0 && $total > 0)
				{
					$objArticles->limit($total, $skipFirst);
				}

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
				$this->Template->articles = $this->parseArticles($objArticles->execute());
				$this->Template->archives = $this->news_archives;
				$this->Template->tags_total_found = $totalfound;
				$this->Template->tags_activetags = $headlinetags;
			}
			else
			{
				$this->Template->articles = array();
				$this->Template->archives = $this->news_archives;
			}
		}
		else
		{
			parent::compile();
		}
	}

	/**
	 * Parse one or more items and return them as array
	 * Identical method as in ModuleNewsReaderTags. On changes, please replace this version with the version of ModuleNewsReaderTags
	 * @param object
	 * @param boolean
	 * @return array
	 */
	protected function parseArticles($objArticles, $blnAddArchive=false)
	{
		$this->Session->set('news_showtags', $this->news_showtags);
		$this->Session->set('news_jumpto', $this->tag_jumpTo);
		$this->Session->set('news_tag_named_class', $this->tag_named_class);
		$result = parent::parseArticles($objArticles, $blnAddArchive);
		$this->Session->set('news_showtags', '');
		$this->Session->set('news_jumpto', '');
		$this->Session->set('news_tag_named_class', '');
		return $result;
	}
}

?>