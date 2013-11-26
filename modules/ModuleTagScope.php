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
 * Class ModuleTagScope
 *
 * @copyright  Helmut Schottmüller 2008 
 * @author     Helmut Schottmüller <typolight@aurealis.de>
 * @package    Controller
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
		if (strlen(\Input::get('tag')))
		{
			array_push($this->arrTags, \Input::get('tag'));
			$relatedlist = (strlen(\Input::get('related'))) ? preg_split("/,/", \Input::get('related')) : array();
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
		$this->loadLanguageFile('tl_module');
		$this->Template->lngTags = (strlen($this->clear_text)) ? $this->clear_text : $GLOBALS['TL_LANG']['tl_module']['tags'];
		$this->Template->jumpTo = $this->jumpTo;
		$this->Template->arrTags = $this->arrTags;
		$objPageObject = $this->Database->prepare("SELECT id, alias FROM tl_page WHERE id=?")
			->limit(1)
			->execute($this->tag_jumpTo);
		$pageArr = ($objPageObject->numRows) ? $objPageObject->fetchAssoc() : array();
		$strParams = '';
		if ($this->keep_url_params)
		{
			$strParams = \TagHelper::getSavedURLParams($this->Input);
		}
		$tagurls = array();
		foreach ($this->arrTags as $idx => $tag)
		{
			if (count($pageArr))
			{
				$strUrl = ampersand($this->generateFrontendUrl($pageArr, '/tag/' . \System::urlencode($tag)));
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
		$strEmptyUrl = ampersand($this->generateFrontendUrl($pageArr, ''));
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
					$tagpath = '/tag/' . \System::urlencode($newarr[0]);
					if (count($newarr) > 1)
					{
						$related = array_slice($newarr, 1);
						$tagpath .= '/related/' . \System::urlencode(join($related, ','));
					}
					$strUrl = ampersand($this->generateFrontendUrl($pageArr, $tagpath));
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

?>