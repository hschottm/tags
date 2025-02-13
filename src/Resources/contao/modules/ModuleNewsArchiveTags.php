<?php

namespace Hschottm\TagsBundle;

use Contao\ModuleNewsArchive;
use Contao\Database;
use Contao\Input;
use Contao\Date;
use Contao\Environment;
use Contao\CoreBundle\Exception\OutOfBoundsException;
use Contao\CoreBundle\Exception\PageNotFoundException;
use Contao\Pagination;
use Contao\Config;
use Contao\NewsModel;

/**
 * Contao Open Source CMS - tags extension
 *
 * Copyright (c) 2008-2024 Helmut Schottmüller
 *
 * @license LGPL-3.0+
 */

class ModuleNewsArchiveTags extends ModuleNewsArchive
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
				\array_push($placeholders, "'" . $tag . "'");
			}
			return Database::getInstance()->prepare("SELECT tid FROM tl_tag WHERE tag IN (" . implode(',', $placeholders) . ") AND from_table = ? ORDER BY tag ASC")
				->execute('tl_news')
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
		global $objPage;

		$limit = null;
		$offset = 0;
		$intBegin = 0;
		$intEnd = 0;

		$intYear = (int) Input::get('year');
		$intMonth = (int) Input::get('month');
		$intDay = (int) Input::get('day');

		// Jump to the current period
		if (Input::get('year') === null && Input::get('month') === null && Input::get('day') === null && $this->news_jumpToCurrent != 'all_items')
		{
			switch ($this->news_format)
			{
				case 'news_year':
					$intYear = date('Y');
					break;

				default:
				case 'news_month':
					$intMonth = date('Ym');
					break;

				case 'news_day':
					$intDay = date('Ymd');
					break;
			}
		}

		// Create the date object
		try
		{
			if ($intYear)
			{
				$strDate = $intYear;
				$objDate = new Date($strDate, 'Y');
				$intBegin = $objDate->yearBegin;
				$intEnd = $objDate->yearEnd;
				$this->headline .= ' ' . date('Y', $objDate->tstamp);
			}
			elseif ($intMonth)
			{
				$strDate = $intMonth;
				$objDate = new Date($strDate, 'Ym');
				$intBegin = $objDate->monthBegin;
				$intEnd = $objDate->monthEnd;
				$this->headline .= ' ' . Date::parse('F Y', $objDate->tstamp);
			}
			elseif ($intDay)
			{
				$strDate = $intDay;
				$objDate = new Date($strDate, 'Ymd');
				$intBegin = $objDate->dayBegin;
				$intEnd = $objDate->dayEnd;
				$this->headline .= ' ' . Date::parse($objPage->dateFormat, $objDate->tstamp);
			}
			elseif ($this->news_jumpToCurrent == 'all_items')
			{
				$intEnd = min(4294967295, PHP_INT_MAX); // 2106-02-07 07:28:15
			}
		}
		catch (\OutOfBoundsException $e)
		{
			throw new PageNotFoundException('Page not found: ' . Environment::get('uri'));
		}

		$this->Template->articles = array();

		// Split the result
		if ($this->perPage > 0)
		{
			// Get the total number of items
			$intTotal = TagsNewsModel::countPublishedFromToByPidsAndIds($intBegin, $intEnd, $this->news_archives, $arrIds);

			if ($intTotal > 0)
			{
				$total = $intTotal;

				// Get the current page
				$id = 'page_a' . $this->id;
				$page = (int) (Input::get($id) ?? 1);

				// Do not index or cache the page if the page number is outside the range
				if ($page < 1 || $page > max(ceil($total/$this->perPage), 1))
				{
					throw new PageNotFoundException('Page not found: ' . Environment::get('uri'));
				}

				// Set limit and offset
				$limit = $this->perPage;
				$offset = (max($page, 1) - 1) * $this->perPage;

				// Add the pagination menu
				$objPagination = new Pagination($total, $this->perPage, Config::get('maxPaginationLinks'), $id);
				$this->Template->pagination = $objPagination->generate("\n  ");
			}
		}

		// Determine sorting
		$t = NewsModel::getTable();
		$arrOptions = array();

		switch ($this->news_order)
		{
			case 'order_headline_asc':
				$arrOptions['order'] = "$t.headline";
				break;

			case 'order_headline_desc':
				$arrOptions['order'] = "$t.headline DESC";
				break;

			case 'order_random':
				$arrOptions['order'] = "RAND()";
				break;

			case 'order_date_asc':
				$arrOptions['order'] = "$t.date";
				break;

			default:
				$arrOptions['order'] = "$t.date DESC";
		}

		// Get the news items
		if (isset($limit))
		{
			$objArticles = TagsNewsModel::findPublishedFromToByPidsAndIds($intBegin, $intEnd, $this->news_archives, $arrIds, $limit, $offset);
		}
		else
		{
			$objArticles = TagsNewsModel::findPublishedFromToByPidsAndIds($intBegin, $intEnd, $this->news_archives, $arrIds);
		}

		// Add the articles
		if ($objArticles !== null)
		{
			$this->Template->articles = $this->parseArticles($objArticles);
		}

		$headlinetags = array();

		if (strlen(TagHelper::decode(Input::get('tag'))))
		{
			$headlinetags = array_merge($headlinetags, array(TagHelper::decode(Input::get('tag'))));
			if (!empty($relatedlist))
			{
				$headlinetags = array_merge($headlinetags, $relatedlist);
			}
		}

		$this->Template->tags_total_found = $total;
		$this->Template->tags_activetags = $headlinetags;
		$this->Template->headline = trim($this->headline);
		$this->Template->back = $GLOBALS['TL_LANG']['MSC']['goBack'];
		$this->Template->empty = $GLOBALS['TL_LANG']['MSC']['empty'];
		
	}
	
	/**
	 * Generate module
	 */
	protected function compile()
	{
		TagHelper::$config['news_showtags'] = $this->news_showtags;
		TagHelper::$config['news_jumpto'] = $this->tag_jumpTo;
		TagHelper::$config['news_tag_named_class'] = $this->tag_named_class;
		if ((strlen(TagHelper::decode(Input::get('tag'))) && (!$this->tag_ignore)) || (strlen($this->tag_filter)))
		{
			$tagids = array();
			
			$relatedlist = (strlen(TagHelper::decode(Input::get('related')))) ? preg_split("/,/", TagHelper::decode(Input::get('related'))) : array();
			$alltags = array_merge(array(TagHelper::decode(Input::get('tag'))), $relatedlist);
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
						$tagids = Database::getInstance()->prepare("SELECT tid FROM tl_tag WHERE from_table = ? AND tag = ? AND tid IN (" . implode(",", $tagids) . ")")
							->execute('tl_news', $tag)
							->fetchEach('tid');
					}
					else if ($first)
					{
						$tagids = Database::getInstance()->prepare("SELECT tid FROM tl_tag WHERE from_table = ? AND tag = ?")
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
	}
}

