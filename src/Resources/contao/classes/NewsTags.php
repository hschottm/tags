<?php

/**
 * Contao Open Source CMS - tags extension
 *
 * Copyright (c) 2009-2024 Helmut Schottmüller
 *
 * @license LGPL-3.0+
 */

 namespace Hschottm\TagsBundle;

use Contao\News;
use Contao\Database;
use Contao\FrontendTemplate;

class NewsTags extends News
{
	private $savedArticleId;
	
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
		global $objPage;
		$arrTags = Database::getInstance()->prepare("SELECT * FROM tl_tag WHERE from_table = ? AND tid = ?")
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
						$objArticle = Database::getInstance()->prepare("SELECT a.id AS aId, a.alias AS aAlias, a.title AS title, p.id AS id, p.alias AS alias FROM tl_article a, tl_page p WHERE a.pid=p.id AND (a.id=? OR a.alias=?)")
							->limit(1)
							->execute($id, $id);
						if ($objArticle->numRows < 1)
						{
							break;
						}
						else
						{
							$strUrl = $objPage->getFrontendUrl('/articles/' . ((!$GLOBALS['TL_CONFIG']['disableAlias'] && strlen($objArticle->aAlias)) ? $objArticle->aAlias : $objArticle->aId));
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

