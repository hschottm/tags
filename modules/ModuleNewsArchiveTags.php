<?php

/**
 * TYPOlight webCMS
 * Copyright (C) 2005 Leo Feyer
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 2.1 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at http://www.gnu.org/licenses/.
 *
 * PHP version 5
 * @copyright  Helmut Schottmüller 2008
 * @author     Helmut Schottmüller <typolight@aurealis.de>
 * @package    tags
 * @license    LGPL
 * @filesource
 */

namespace Contao;

if (!defined('TL_ROOT')) die('You can not access this file directly!');


/**
 * Class ModuleNewsArchiveTags
 *
 * Front end module "news archive with tags support".
 * @copyright  Helmut Schottmüller 2008
 * @author     Helmut Schottmüller <typolight@aurealis.de>
 * @package    Controller
 */
class ModuleNewsArchiveTags extends \ModuleNewsArchive
{
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
			$limit = null;
			$offset = 0;
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
			if (count($tagids))
			{
				$limit = null;
				$offset = 0;

				// Jump to the current period
				if (!isset($_GET['year']) && !isset($_GET['month']) && !isset($_GET['day']) && $this->news_jumpToCurrent != 'all_items')
				{
					switch ($this->news_format)
					{
						case 'news_year':
							\Input::setGet('year', date('Y'));
							break;

						default:
						case 'news_month':
							\Input::setGet('month', date('Ym'));
							break;

						case 'news_day':
							\Input::setGet('day', date('Ymd'));
							break;
					}
				}

				// Display year
				if (\Input::get('year'))
				{
					$strDate = \Input::get('year');
					$objDate = new Date($strDate, 'Y');
					$intBegin = $objDate->yearBegin;
					$intEnd = $objDate->yearEnd;
					$this->headline .= ' ' . date('Y', $objDate->tstamp);
				}

				// Display month
				elseif (\Input::get('month'))
				{
					$strDate = \Input::get('month');
					$objDate = new Date($strDate, 'Ym');
					$intBegin = $objDate->monthBegin;
					$intEnd = $objDate->monthEnd;
					$this->headline .= ' ' . $this->parseDate('F Y', $objDate->tstamp);
				}

				// Display day
				elseif (\Input::get('day'))
				{
					$strDate = \Input::get('day');
					$objDate = new Date($strDate, 'Ymd');
					$intBegin = $objDate->dayBegin;
					$intEnd = $objDate->dayEnd;
					$this->headline .= ' ' . $this->parseDate($GLOBALS['TL_CONFIG']['dateFormat'], $objDate->tstamp);
				}

				// Show all items 
				elseif ($this->news_jumpToCurrent == 'all_items')
				{
					$intBegin = 0;
					$intEnd = time();
				}

				$time = time();

				// Split result
				if ($this->perPage > 0)
				{
					// Get the total number of items
					$objTotal = $this->Database->prepare("SELECT COUNT(*) AS total FROM tl_news WHERE pid IN(" . implode(',', array_map('intval', $this->news_archives)) . ") AND date>=? AND date<=? AND id IN (" . join($tagids, ",") . ")" . (!BE_USER_LOGGED_IN ? " AND (start='' OR start<$time) AND (stop='' OR stop>$time) AND published=1" : "") . " ORDER BY date DESC")
											   ->execute($intBegin, $intEnd);

					$total = $objTotal->total;

					// Get the current page
					$page = \Input::get('page') ? \Input::get('page') : 1;

					if ($page > ($total/$this->perPage))
					{
						$page = ceil($total/$this->perPage);
					}

					// Set limit and offset
					$limit = $this->perPage;
					$offset = ((($page > 1) ? $page : 1) - 1) * $this->perPage;

					// Add the pagination menu
					$objPagination = new Pagination($total, $this->perPage);
					$this->Template->pagination = $objPagination->generate("\n  ");
				}

				$objArticlesStmt = $this->Database->prepare("SELECT *, author AS authorId, (SELECT title FROM tl_news_archive WHERE tl_news_archive.id=tl_news.pid) AS archive, (SELECT jumpTo FROM tl_news_archive WHERE tl_news_archive.id=tl_news.pid) AS parentJumpTo, (SELECT name FROM tl_user WHERE id=author) AS author FROM tl_news WHERE pid IN(" . implode(',', array_map('intval', $this->news_archives)) . ") AND date>=? AND date<=? AND id IN (" . join($tagids, ",") . ")" . (!BE_USER_LOGGED_IN ? " AND (start='' OR start<$time) AND (stop='' OR stop>$time) AND published=1" : "") . " ORDER BY date DESC");

				// Limit result
				if ($limit)
				{
					$objArticlesStmt->limit($limit, $offset);
				}

				$objArticles = $objArticlesStmt->execute($intBegin, $intEnd);

				// No items found
				if ($objArticles->numRows < 1)
				{
					$this->Template = new FrontendTemplate('mod_newsarchive_empty');
				}

				$headlinetags = array();

				if (strlen(\Input::get('tag')))
				{
					$headlinetags = array_merge($headlinetags, array(\Input::get('tag')));
					if (count($relatedlist))
					{
						$headlinetags = array_merge($headlinetags, $relatedlist);
					}
				}
				$this->Template->tags_total_found = $total;
				$this->Template->tags_activetags = $headlinetags;
				$this->Template->headline = trim($this->headline);
				$this->Template->articles = $this->parseArticles($objArticles);
				$this->Template->back = $GLOBALS['TL_LANG']['MSC']['goBack'];
				$this->Template->empty = $GLOBALS['TL_LANG']['MSC']['empty'];
			}
			else
			{
				$this->Template = new FrontendTemplate('mod_newsarchive_empty');
			}
		}
		else
		{
			parent::compile();
		}
	}

	/**
	 * Parse one or more items and return them as array
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