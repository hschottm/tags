<?php

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2011 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Helmut Schottmüller 2011
 * @author     Helmut Schottmüller <http://www.aurealis.de>
 * @package    News
 * @license    LGPL
 * @filesource
 */

namespace Contao;

if (!defined('TL_ROOT')) die('You can not access this file directly!');


/**
 * Class CalendarTags
 *
 * Provide methods regarding news archives.
 * @copyright  Helmut Schottmüller 2011
 * @author     Helmut Schottmüller <http://www.aurealis.de>
 * @package    Controller
 */
class NewsTags extends \News
{
	private $savedArticleId;
	
	/**
	 * Convert relative URLs to absolute URLs
	 * @param string
	 * @param string
	 * @param boolean
	 * @return string
	 */
	/* TODO: No longer possible in Contao 3
	protected function convertRelativeUrls($strContent, $strBase='', $blnHrefOnly=false)
	{
		$content = \Controller::convertRelativeURLs($strContent, $strBase, $blnHrefOnly);
		if ($GLOBALS['tags']['showInFeeds'])
		{
			$tags = $this->getTagsForTableAndId('tl_news', $this->savedArticleId);
			if (strlen($tags))
			{
				$content .= $tags;
			}
		}
		return $content;
	}
	*/
	/**
	 * Return the link of a news article
	 * @param object
	 * @param string
	 * @return string
	 */
	protected function getLink($objItem, $strUrl, $strBase='')
	{
		$this->savedArticleId = $objItem->id;
		return parent::getLink($objItem, $strUrl, $strBase);
	}
	
	private function getTagsForTableAndId($table, $id, $url = false)
	{
		$arrTags = $this->Database->prepare("SELECT * FROM tl_tag WHERE from_table = ? AND tid = ?")
			->execute($table, $id)
			->fetchAllAssoc();
		$res = false;
		$strUrl = '';
		if (count($arrTags))
		{
			if ($url)
			{
				switch ($table)
				{
					case 'tl_article':
						$objArticle = $this->Database->prepare("SELECT a.id AS aId, a.alias AS aAlias, a.title AS title, p.id AS id, p.alias AS alias FROM tl_article a, tl_page p WHERE a.pid=p.id AND (a.id=? OR a.alias=?)")
							->limit(1)
							->execute($id, $id);
						if ($objArticle->numRows < 1)
						{
							break;
						}
						else
						{
							$strUrl = $this->generateFrontendUrl($objArticle->row(), '/articles/' . ((!$GLOBALS['TL_CONFIG']['disableAlias'] && strlen($objArticle->aAlias)) ? $objArticle->aAlias : $objArticle->aId));
						}
						break;
				}
			}
			$objTemplate = new FrontendTemplate('tags_inserttag');
			$objTemplate->tags = $arrTags;
			$objTemplate->url = $strUrl;
			$res = $objTemplate->parse();
		}
		return $res;
	}
}

?>