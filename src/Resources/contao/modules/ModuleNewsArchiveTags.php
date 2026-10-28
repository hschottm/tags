<?php

namespace Hschottm\TagsBundle;

use Contao\ModuleNewsArchive;
use Contao\NewsModel;
use Contao\Input;
use Contao\Date;
use Contao\Environment;
use Contao\System;
use Contao\CoreBundle\Exception\PageNotFoundException;
use Contao\Config;
use Contao\Pagination;
use Hschottm\TagsBundle\Service\TagFilter;

/**
 * Contains an adapted Contao core method, (c) Leo Feyer, LGPL-3.0-or-later.
 * See docs/UPSTREAM.md for the source revision and maintenance procedure.
 */
class ModuleNewsArchiveTags extends ModuleNewsArchive
{
    protected function compile()
    {
        $filter = System::getContainer()->get(TagFilter::class);
        $ids = $filter->findIds('tl_news', (string) $this->tag_filter, (bool) $this->tag_ignore);
        if ($ids === null) {
            parent::compile();
        } else {
            $this->compileFromParent($ids);
        }
        $this->Template->tags_activetags = $filter->activeTags((string) $this->tag_filter, (bool) $this->tag_ignore);
    }

	protected function compileFromParent(array $ids)
	{
        // BEGIN CORE ADAPTATION: Contao\ModuleNewsArchive::compile(), Contao 5.3.52.
        // Source: contao/news-bundle/contao/modules/ModuleNewsArchive.php
        // There are no count/fetch hooks in this module. Keep the core control flow
        // (date range, pagination, order and rendering); TAGS markers identify changes.
        // The upstream method fingerprint is checked by tests/upstream.php.
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

        // TAGS BEGIN: expose a total even when pagination is disabled.
        $tagTotal = TagsNewsModel::countPublishedFromToByPidsAndIds($intBegin, $intEnd, $this->news_archives, $ids);
        $this->Template->tags_total_found = $tagTotal;
        // TAGS END

		// Split the result
		if ($this->perPage > 0)
		{
			// Get the total number of items
			$intTotal = $tagTotal; // TAGS: filtered count calculated above.

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
			// TAGS: add ID constraint; retain core limit, offset and sorting.
			$objArticles = TagsNewsModel::findPublishedFromToByPidsAndIds($intBegin, $intEnd, $this->news_archives, $ids, $limit, $offset, $arrOptions);
		}
		else
		{
			// TAGS: same ID constraint when pagination is disabled.
			$objArticles = TagsNewsModel::findPublishedFromToByPidsAndIds($intBegin, $intEnd, $this->news_archives, $ids, 0, 0, $arrOptions);
		}

		// Add the articles
		if ($objArticles !== null)
		{
			$this->Template->articles = $this->parseArticles($objArticles);
		}

		$this->Template->headline = trim($this->headline);
		$this->Template->back = $GLOBALS['TL_LANG']['MSC']['goBack'];
		$this->Template->empty = $GLOBALS['TL_LANG']['MSC']['empty'];
        // END CORE ADAPTATION
	}
}
