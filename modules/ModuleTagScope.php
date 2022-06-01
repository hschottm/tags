<?php

namespace Contao;

/**
 * Contao Open Source CMS - tags extension
 *
 * Copyright (c) 2008-2016 Helmut Schottmüller
 *
 * @license LGPL-3.0+
 */

class ModuleTagScope extends \Module
{
	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_tagscope';

	/**
	 * Tags
	 * @var array
	 */
	protected $arrTags = array();

	/**
	 * Display a wildcard in the back end
	 * @return string
	 */
	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new BackendTemplate('be_wildcard');
			$objTemplate->wildcard = '### TAGSCOPE ###';

			return $objTemplate->parse();
		}

		$this->strTemplate = (strlen($this->scope_template)) ? $this->scope_template : $this->strTemplate;
		$this->arrTags = array();
		if (strlen(\TagHelper::decode(\Input::get('tag'))))
		{
			array_push($this->arrTags, \TagHelper::decode(\Input::get('tag')));
			$relatedlist = (strlen(\TagHelper::decode(\Input::get('related')))) ? preg_split("/,/", \TagHelper::decode(\Input::get('related'))) : array();
			$this->arrTags = array_merge($this->arrTags, $relatedlist);
		}
		if (count($this->arrTags) < 1 && $this->show_empty_scope == false)
		{
			return '';
		}
		return parent::generate();
	}

	/**
	 * Generate module
	 */
	protected function compile()
	{
		global $objPage;
		$this->loadLanguageFile('tl_module');
		$this->Template->lngTags = (strlen($this->clear_text)) ? $this->clear_text : $GLOBALS['TL_LANG']['tl_module']['tags'];
		$this->Template->jumpTo = $this->jumpTo;
		$this->Template->arrTags = $this->arrTags;

		$pageObj = \TagHelper::getPageObj($this->tag_jumpTo);
		$strParams = '';
		if ($this->keep_url_params)
		{
			$strParams = \TagHelper::getSavedURLParams($this->Input);
		}
		$tagurls = array();
		foreach ($this->arrTags as $idx => $tag)
		{
			if (!empty($pageObj))
			{
				$strUrl = StringUtil::ampersand($pageObj->getFrontendUrl('/tag/' . \TagHelper::encode($tag)));
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
				$tagurls[$tag] = $strUrl;
			}
		}
		$this->Template->tag_urls = $tagurls;
		$strEmptyUrl = StringUtil::ampersand($pageObj->getFrontendUrl());
		if (strlen($strParams))
		{
			if (strpos($strEmptyUrl, '?') !== false)
			{
				$strEmptyUrl .= '&amp;' . $strParams;
			}
			else
			{
				$strEmptyUrl .= '?' . $strParams;
			}
		}
		$this->Template->empty_url = $strEmptyUrl;
		$deleteUrls = array();
		if (count($this->arrTags) > 0)
		{
			if (count($this->arrTags) == 1)
			{
				$deleteUrls[$this->arrTags[0]] = $strEmptyUrl;
			}
			else
			{
				foreach ($this->arrTags as $idx => $tag)
				{
					$newarr = array();
					foreach ($this->arrTags as $idxnew => $tagnew)
					{
						if ($idxnew != $idx)
						{
							array_push($newarr, $tagnew);
						}
					}
					$tagpath = '/tag/' . $newarr[0];
					if (count($newarr) > 1)
					{
						$related = array_slice($newarr, 1);
						$tagpath .= '/related/' . implode(',',$related);
					}
					$strUrl = StringUtil::ampersand($pageObj->getFrontendUrl($tagpath));
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
					$deleteUrls[$tag] = $strUrl;
				}
			}
		}
		$this->Template->delete_urls = $deleteUrls;
	}
}
