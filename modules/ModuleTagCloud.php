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
 * Class ModuleTagCloud
 *
 * @copyright  Helmut Schottmüller 2008 
 * @author     Helmut Schottmüller <typolight@aurealis.de>
 * @package    Controller
 */
class ModuleTagCloud extends \Module
{
	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_tagcloud';

	/**
	 * Tags
	 * @var array
	 */
	protected $arrTags = array();
	protected $arrTopTenTags = array();
	protected $arrRelated = array();
	protected $checkForArticleOnPage = false;
	protected $checkForContentElementOnPage = false;

	protected function toggleTagCloud()
	{
		if (\Input::post('toggleTagCloud') == 1)
		{
			$ts = deserialize(\Input::cookie('tagcloud_states'), true);
			$ts[\Input::post('cloudPageID')][\Input::post('cloudID')] = \Input::post('display');
			$this->setCookie('tagcloud_states', serialize($ts), (time() + 60*60*24*30), $GLOBALS['TL_CONFIG']['websitePath']);
		}
	}

	/**
	 * Display a wildcard in the back end
	 * @return string
	 */
	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new BackendTemplate('be_wildcard');
			$objTemplate->wildcard = '### TAGCLOUD ###';

			return $objTemplate->parse();
		}

		$this->strTemplate = (strlen($this->cloud_template)) ? $this->cloud_template : $this->strTemplate;

		$taglist = new TagList();
		$taglist->addNamedClass = $this->tag_named_class;
		if (strlen($this->tag_tagtable)) $taglist->tagtable = $this->tag_tagtable;
		if (strlen($this->tag_tagfield)) $taglist->tagfield = $this->tag_tagfield;
		if (strlen($this->tag_sourcetables)) $taglist->fortable = deserialize($this->tag_sourcetables, TRUE);
		if (strlen($this->tag_maxtags)) $taglist->maxtags = $this->tag_maxtags;
		if (strlen($this->tag_buckets) && $this->tag_buckets > 0) $taglist->buckets = $this->tag_buckets;
		if (strlen($this->pagesource)) $taglist->pagesource = deserialize($this->pagesource, TRUE);
		$this->arrTags = $taglist->getTagList();
		if ($this->tag_topten) $this->arrTopTenTags = $taglist->getTopTenTagList();
		if (strlen(\Input::get('tag')) && $this->tag_related)
		{
			$relatedlist = (strlen(\Input::get('related'))) ? preg_split("/,/", \Input::get('related')) : array();
			$this->arrRelated = $taglist->getRelatedTagList(array_merge(array(\Input::get('tag')), $relatedlist));
		}
		if (count($this->arrTags) < 1)
		{
			return '';
		}
		$this->toggleTagCloud();
		return parent::generate();
	}

	/**
	 * Generate module
	 */
	protected function compile()
	{
		$this->import('String');
		$this->showTags();
	}

	/**
	 * Show tag list
	 */
	protected function showTags()
	{
		$this->loadLanguageFile('tl_module');
		$strUrl = ampersand(\Environment::get('request'), ENCODE_AMPERSANDS);
		// Get target page
		$objPageObject = $this->Database->prepare("SELECT id, alias FROM tl_page WHERE id=?")
			->limit(1)
			->execute($this->tag_jumpTo);
		global $objPage;
		$default = ($objPage != null) ? $objPage->row() : array();
		$pageArr = ($objPageObject->numRows) ? $objPageObject->fetchAssoc() : $default;
		$strParams = '';
		if ($this->keep_url_params)
		{
			$strParams = \TagHelper::getSavedURLParams($this->Input);
		}
		foreach ($this->arrTags as $idx => $tag)
		{
			if (count($pageArr))
			{
				$strUrl = ampersand($this->generateFrontendUrl($pageArr, '/tag/' . \System::urlencode($tag['tag_name'])));
				if (strlen($strParams))
				{
					if (strpos($strUrl, '?') !== false)
					{
						$strUrl .= '&amp;' . $strParams;
					}
					else
					{
						$strUrl .= '?' . $strParams;
					}
				}
			}
			$this->arrTags[$idx]['tag_url'] = $strUrl;
			if ($tag['tag_name'] == \Input::get('tag'))
			{
				$this->arrTags[$idx]['tag_class'] .= ' active';
			}
			if ($this->checkForArticleOnPage)
			{
				global $objPage;
				// get articles on page
				$arrArticles = $this->Database->prepare("SELECT id FROM tl_article WHERE pid = ?")
					->execute($objPage->id)->fetchEach('id');
				$arrTagIds = $this->Database->prepare("SELECT tid FROM " . $this->tag_tagtable . " WHERE from_table = ? AND tag = ?")
					->execute('tl_article', $tag['tag_name'])->fetchEach('tid');
				if (count(array_intersect($arrArticles, $arrTagIds)))
				{
					$this->arrTags[$idx]['tag_class'] .= ' here';
				}
			}
			if ($this->checkForContentElementOnPage)
			{
				global $objPage;
				// get articles on page
				$arrArticles = $this->Database->prepare("SELECT id FROM tl_article WHERE pid = ?")
					->execute($objPage->id)->fetchEach('id');
				if (count($arrArticles))
				{
					$arrCE = $this->Database->prepare("SELECT id FROM tl_content WHERE pid IN (" . implode(",", $arrArticles) . ")")
						->execute()->fetchEach('id');
					$arrTagIds = $this->Database->prepare("SELECT tid FROM " . $this->tag_tagtable . " WHERE from_table = ? AND tag = ?")
						->execute('tl_content', $tag['tag_name'])->fetchEach('tid');
					if (count(array_intersect($arrCE, $arrTagIds)))
					{
						$this->arrTags[$idx]['tag_class'] .= ' here';
					}
				}
			}
		}
		$relatedlist = (strlen(\Input::get('related'))) ? preg_split("/,/", \Input::get('related')) : array();
		foreach ($this->arrRelated as $idx => $tag)
		{
			if (count($pageArr))
			{
				$strUrl = ampersand($this->generateFrontendUrl($pageArr, '/tag/' . \System::urlencode(\Input::get('tag')) . '/related/' . \System::urlencode(join(array_merge($relatedlist, array($tag['tag_name'])), ','))));
			}
			$this->arrRelated[$idx]['tag_url'] = $strUrl;
		}
		$this->Template->pageID = $this->id;
		$this->Template->tags = $this->arrTags;
		$this->Template->jumpTo = $this->jumpTo;
		$this->Template->relatedtags = $this->arrRelated;
		$this->Template->strRelatedTags = $GLOBALS['TL_LANG']['tl_module']['tag_relatedtags'];
		$this->Template->strAllTags = $GLOBALS['TL_LANG']['tl_module']['tag_alltags'];
		$this->Template->strTopTenTags = $GLOBALS['TL_LANG']['tl_module']['tag_topten'][0];
		$this->Template->tagcount = count($this->arrTags);
		$this->Template->selectedtags = (strlen(\Input::get('tag'))) ? (count($this->arrRelated)+1) : 0;
		if ($this->tag_show_reset)
		{
			$strEmptyUrl = ampersand($this->generateFrontendUrl($pageArr, ''));
			if (strlen($strParams))
			{
				if (strpos($strUrl, '?') !== false)
				{
					$strEmptyUrl .= '&amp;' . $strParams;
				}
				else
				{
					$strEmptyUrl .= '?' . $strParams;
				}
			}
			$this->Template->empty_url = $strEmptyUrl;
			$this->Template->lngEmpty = $GLOBALS['TL_LANG']['tl_module']['tag_clear_tags'];
		}
		$GLOBALS['TL_JAVASCRIPT'][] = 'system/modules/tags/assets/tagcloud.js';
		if (count($pageArr))
		{
			$this->Template->topten = $this->tag_topten;
			if ($this->tag_topten)
			{
				foreach ($this->arrTopTenTags as $idx => $tag)
				{
					if (count($pageArr))
					{
						$strUrl = ampersand($this->generateFrontendUrl($pageArr, '/tag/' . \System::urlencode($tag['tag_name'])));
						if (strlen($strParams))
						{
							if (strpos($strUrl, '?') !== false)
							{
								$strUrl .= '&amp;' . $strParams;
							}
							else
							{
								$strUrl .= '?' . $strParams;
							}
						}
					}
					$this->arrTopTenTags[$idx]['tag_url'] = $strUrl;
				}
				$ts = deserialize(\Input::cookie('tagcloud_states'), true);
//				$ts = $this->Session->get('tagcloud_states');
				$this->Template->expandedTopTen = (strlen($ts[$this->id]['topten'])) ? ((strcmp($ts[$this->id]['topten'], 'none') == 0) ? 0 : 1) : $this->tag_topten_expanded;
				$this->Template->expandedAll = (strlen($ts[$this->id]['alltags'])) ? ((strcmp($ts[$this->id]['alltags'], 'none') == 0) ? 0 : 1) : $this->tag_all_expanded;
				$this->Template->expandedRelated = (strlen($ts[$this->id]['related'])) ? ((strcmp($ts[$this->id]['related'], 'none') == 0) ? 0 : 1) : 1;
				$this->Template->toptentags = $this->arrTopTenTags;
			}
		}
	}

	/**
	 * Add specific attributes
	 * @param string
	 * @param mixed
	 */
	public function __set($strKey, $varValue)
	{
		switch ($strKey)
		{
			case 'checkForArticleOnPage':
				$this->checkForArticleOnPage = $varValue;
				break;
			case 'checkForContentElementOnPage':
				$this->checkForContentElementOnPage = $varValue;
				break;
			default:
				parent::__set($strKey, $varValue);
				break;
		}
	}

	/**
	 * Return a parameter
	 * @return string
	 * @throws Exception
	 */
	public function __get($strKey)
	{
		switch ($strKey)
		{
			case 'checkForArticleOnPage':
				return $this->checkForArticleOnPage;
				break;
			case 'checkForContentElementOnPage':
				return $this->checkForContentElementOnPage;
				break;
			default:
				return parent::__get($strKey);
				break;
		}
	}
}

?>