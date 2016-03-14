<?php

namespace Aurealis;

/**
 * Contao Open Source CMS - tags extension
 *
 * Copyright (c) 2008-2016 Helmut Schottmüller
 *
 * @license LGPL-3.0+
 */

class ModuleArticle extends \Contao\ModuleArticle
{
	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_article_tags';

	/**
	 * Generate the module
	 */
	protected function compile()
	{
		\Contao\ModuleArticle::compile();
		$this->Template->show_tags = $this->tags_showtags;
		if ($this->tags_showtags)
		{
			$this->Template->tags = $this->getTagsForArticle($this->tags_max_tags, $this->tags_relevance, $this->tags_jumpto);
		}
	}

	public function sortByRelevance($a, $b)
	{
		if ($a['tagcount'] == $b['tagcount']) 
		{
			return 0;
		}
		return ($a['tagcount'] < $b['tagcount']) ? 1 : -1;
	} 

	private function getTagsForArticle($max_tags = 0, $relevance = 0, $target = 0)
	{
		$table = 'tl_article';
		$id = $this->id;
		$arrTags = $this->Database->prepare("SELECT * FROM tl_tag WHERE from_table = ? AND tid = ? ORDER BY tag ASC")
			->execute($table, $id)
			->fetchAllAssoc();
		$res = false;
		if (count($arrTags))
		{
			if ($max_tags > 0)
			{
				$arrTags = array_slice($arrTags,0,$max_tags);
			}
			$arrTagsWithCount = $this->Database->prepare("SELECT tag, COUNT(tag) as tagcount FROM tl_tag WHERE from_table = ? GROUP BY tag ORDER BY tag ASC")
				->execute($table)
				->fetchAllAssoc();
			$countarray = array();
			foreach ($arrTagsWithCount as $data)
			{
				$countarray[$data['tag']] = $data['tagcount'];
			}
			foreach ($arrTags as $idx => $tag)
			{
				$arrTags[$idx]['tagcount'] = $countarray[$tag['tag']];
				$arrTags[$idx]['tag_class'] = \Contao\TagList::_getTagNameClass($tag['tag']);
			}
			if ($relevance == 1)
			{
				usort($arrTags, array($this, 'sortByRelevance'));
			}
			if (strlen($target))
			{
				$pageArr = array();
				$objFoundPage = $this->Database->prepare("SELECT id, alias FROM tl_page WHERE id=? OR alias=?")
					->limit(1)
					->execute(array($target, $target));
				$pageArr = ($objFoundPage->numRows) ? $objFoundPage->fetchAssoc() : array();
				if (count($pageArr))
				{
					foreach ($arrTags as $idx => $tag)
					{
						$arrTags[$idx]['url'] = ampersand($this->generateFrontendUrl($pageArr, '/tag/' . $tag['tag']));
					}
				}
			}
		}
		return $arrTags;
	}
}
