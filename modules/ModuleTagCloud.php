<?php

namespace Contao;

/**
 * Contao Open Source CMS - tags extension
 *
 * Copyright (c) 2008-2016 Helmut Schottmüller
 *
 * @license LGPL-3.0+
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

	public static $tagCloudStates = array();

	protected function toggleTagCloud()
	{
		if (\Input::post('toggleTagCloud') == 1)
		{
			static::$tagCloudStates[\Input::post('cloudPageID')][\Input::post('cloudID')] = \Input::post('display');
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
		if (strlen($this->tag_topten_number) && $this->tag_topten_number > 0) $taglist->topnumber = $this->tag_topten_number;
		if (strlen($this->tag_maxtags)) $taglist->maxtags = $this->tag_maxtags;
		if (strlen($this->tag_buckets) && $this->tag_buckets > 0) $taglist->buckets = $this->tag_buckets;
		if (strlen($this->pagesource)) $taglist->pagesource = deserialize($this->pagesource, TRUE);
		$this->arrTags = $taglist->getTagList();
		if ($this->tag_topten) $this->arrTopTenTags = $taglist->getTopTenTagList();
		if (strlen(\TagHelper::decode(\Input::get('tag'))) && $this->tag_related)
		{
			$relatedlist = (strlen(\TagHelper::decode(\Input::get('related')))) ? preg_split("/,/", \TagHelper::decode(\Input::get('related'))) : array();
			$this->arrRelated = $taglist->getRelatedTagList(array_merge(array(\TagHelper::decode(\Input::get('tag'))), $relatedlist));
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
		$this->showTags();
	}

	/**
	 * Show tag list
	 */
	protected function showTags()
	{
		global $objPage;
		$this->loadLanguageFile('tl_module');
		$strUrl = StringUtil::ampersand(\Environment::get('request'));
		// Get target page

		$pageObj = \TagHelper::getPageObj($this->tag_jumpTo);

		// $default = ($objPage != null) ? $objPage->row() : array();
		// $pageArr = ($objPageObject->numRows) ? $objPageObject->fetchAssoc() : $default;
		$strParams = '';

		if ($this->keep_url_params)
		{
			$strParams = \TagHelper::getSavedURLParams($this->Input);
		}

		$relatedlist = (strlen(\TagHelper::decode(\Input::get('related')))) ? preg_split("/,/", \TagHelper::decode(\Input::get('related'))) : array();

		foreach ($this->arrTags as $idx => $tag)
		{
			if (!empty($pageObj))
			{
				$strUrl = StringUtil::ampersand($pageObj->getFrontendUrl('/tag/' . \TagHelper::encode($tag['tag_name'])));
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
			if ($tag['tag_name'] == \TagHelper::decode(\Input::get('tag')))
			{
				$this->arrTags[$idx]['tag_class'] .= ' active';
			}
			if (in_array($tag['tag_name'], $relatedlist)) {
				$this->arrTags[$idx]['tag_class'] .= ' related';
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
		foreach ($this->arrRelated as $idx => $tag)
		{
			if (!empty($pageObj))
			{
				$allrelated = array_merge($relatedlist, array($tag['tag_name']));
				$strUrl = StringUtil::ampersand($pageObj->getFrontendUrl('/tag/' . \TagHelper::encode(\TagHelper::decode(\Input::get('tag'))) . '/related/' . \TagHelper::encode(implode(',', $allrelated))));
			}
			$this->arrRelated[$idx]['tag_url'] = $strUrl;
		}
		$this->Template->pageID = $this->id;
		$this->Template->tags = $this->arrTags;
		$this->Template->jumpTo = $this->jumpTo;
		$this->Template->relatedtags = $this->arrRelated;
		$this->Template->strRelatedTags = $GLOBALS['TL_LANG']['tl_module']['tag_relatedtags'];
		$this->Template->strAllTags = $GLOBALS['TL_LANG']['tl_module']['tag_alltags'];
		$this->Template->strTopTenTags = sprintf($GLOBALS['TL_LANG']['tl_module']['top_tags'], $this->tag_topten_number);
		$this->Template->tagcount = count($this->arrTags);
		$this->Template->selectedtags = (strlen(\TagHelper::decode(\Input::get('tag')))) ? (count($this->arrRelated)+1) : 0;
		if ($this->tag_show_reset)
		{
			$strEmptyUrl = StringUtil::ampersand($objPage->getFrontendUrl(''));
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
		if (!empty($pageObj))
		{
			$this->Template->topten = $this->tag_topten;
			if ($this->tag_topten)
			{
				foreach ($this->arrTopTenTags as $idx => $tag)
				{
					$strUrl = StringUtil::ampersand($pageObj->getFrontendUrl('/tag/' . \TagHelper::encode($tag['tag_name'])));
					if ($tag['tag_name'] == \TagHelper::decode(\Input::get('tag')))
					{
						$this->arrTopTenTags[$idx]['tag_class'] .= ' active';
					}
					if (in_array($tag['tag_name'], $relatedlist)) {
						$this->arrTopTenTags[$idx]['tag_class'] .= ' related';
					}
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
					$this->arrTopTenTags[$idx]['tag_url'] = $strUrl;
				}
				$topten = "";
				$expandedAll = "";
				$expandedRelated = "";
				if (array_key_exists($this->id, static::$tagCloudStates)) {
					$topten = static::$tagCloudStates[$this->id]['topten'];
					$expandedAll = static::$tagCloudStates[$this->id]['alltags'];
					$expandedRelated = static::$tagCloudStates[$this->id]['related'];
				}
				$this->Template->expandedTopTen = (strlen($topten)) ? ((strcmp($topten, 'none') == 0) ? 0 : 1) : $this->tag_topten_expanded;
				$this->Template->expandedAll = (strlen($expandedAll)) ? ((strcmp($expandedAll, 'none') == 0) ? 0 : 1) : $this->tag_all_expanded;
				$this->Template->expandedRelated = (strlen($expandedRelated)) ? ((strcmp($expandedRelated, 'none') == 0) ? 0 : 1) : 1;
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
