<?php

namespace Contao;

/**
 * Contao Open Source CMS - tags extension
 *
 * Copyright (c) 2008-2016 Helmut Schottmüller
 *
 * @license LGPL-3.0+
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
			return $this->Database->prepare("SELECT tid FROM tl_tag WHERE tag IN (" . implode(',', $placeholders) . ") AND from_table = ? ORDER BY tag ASC")
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
		$limit = null;
		$offset = intval($this->skipFirst);

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

		$this->Template->articles = array();
		$this->Template->empty = $GLOBALS['TL_LANG']['MSC']['emptyList'];

		// Get the total number of items
		$intTotal = \TagsNewsModel::countPublishedByPidsAndIds($this->news_archives, $arrIds, $blnFeatured);

		if ($intTotal < 1)
		{
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
			$page = (\Input::get($id) !== null) ? \Input::get($id) : 1;

			// Do not index or cache the page if the page number is outside the range
			if ($page < 1 || $page > max(ceil($total/$this->perPage), 1))
			{
				/** @var \PageModel $objPage */
				global $objPage;

				/** @var \PageError404 $objHandler */
				$objHandler = new $GLOBALS['TL_PTY']['error_404']();
				$objHandler->generate($objPage->id);
			}

			// Set limit and offset
			$limit = $this->perPage;
			$offset += (max($page, 1) - 1) * $this->perPage;
			$skip = intval($this->skipFirst);

			// Overall limit
			if ($offset + $limit > $total + $skip)
			{
				$limit = $total + $skip - $offset;
			}

			// Add the pagination menu
			$objPagination = new \Pagination($total, $this->perPage, \Config::get('maxPaginationLinks'), $id);
			$this->Template->pagination = $objPagination->generate("\n  ");
		}

        // Determine sorting
        $t = NewsModel::getTable();
        $order = '';

        if ($this->news_featured == 'featured_first')
        {
            $order .= "$t.featured DESC, ";
        }

        switch ($this->news_order)
        {
            case 'order_headline_asc':
                $order .= "$t.headline";
                break;

            case 'order_headline_desc':
                $order .= "$t.headline DESC";
                break;

            case 'order_random':
                $order .= "RAND()";
                break;

            case 'order_date_asc':
                $order .= "$t.date";
                break;

            default:
                $order .= "$t.date DESC";
        }

		// Get the items
		if (isset($limit))
		{
			$objArticles = \TagsNewsModel::findPublishedByPidsAndIds($this->news_archives, $arrIds, $blnFeatured, $limit, $offset, array('order'=>$order));
		}
		else
		{
			$objArticles = \TagsNewsModel::findPublishedByPidsAndIds($this->news_archives, $arrIds, $blnFeatured, 0, $offset, array('order'=>$order));
		}

		// Add the articles
		if ($objArticles !== null)
		{
			$this->Template->articles = $this->parseArticles($objArticles);
		}

		$this->Template->archives = $this->news_archives;
		// new code for tags
		$relatedlist = (strlen(\TagHelper::decode(\Input::get('related')))) ? preg_split("/,/", \TagHelper::decode(\Input::get('related'))) : array();
		$headlinetags = array();
		if (strlen(\TagHelper::decode(\Input::get('tag'))))
		{
			$headlinetags = array_merge($headlinetags, array(\TagHelper::decode(\Input::get('tag'))));
			if (!empty($relatedlist))
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
		\TagHelper::$config['news_showtags'] = $this->news_showtags;
		\TagHelper::$config['news_jumpto'] = $this->tag_jumpTo;
		\TagHelper::$config['news_tag_named_class'] = $this->tag_named_class;
		if ((strlen(\TagHelper::decode(\Input::get('tag'))) && (!$this->tag_ignore)) || (strlen($this->tag_filter)))
		{
			$tagids = array();
			
			$relatedlist = (strlen(\TagHelper::decode(\Input::get('related')))) ? preg_split("/,/", \TagHelper::decode(\Input::get('related'))) : array();
			$alltags = array_merge(array(\TagHelper::decode(\Input::get('tag'))), $relatedlist);
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
						$tagids = $this->Database->prepare("SELECT tid FROM tl_tag WHERE from_table = ? AND tag = ? AND tid IN (" . implode(",", $tagids) . ")")
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
	}
}

