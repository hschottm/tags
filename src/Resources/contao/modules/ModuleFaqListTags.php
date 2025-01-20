<?php

namespace Hschottm\TagsBundle;

use Contao\FaqCategoryModel;
use Contao\ModuleFaqList;
use Contao\Database;
use Contao\StringUtil;
use Contao\System;

/**
 * Contao Open Source CMS - tags extension
 *
 * Copyright (c) 2008-2024 Helmut Schottmüller
 *
 * @license LGPL-3.0+
 */

class ModuleFaqListTags extends ModuleFaqList
{
	/**
	 * Generate the module
	 */
	protected function compile()
	{
		$tagids = array();
		if (strlen(TagHelper::decode(\Contao\Input::get('tag'))))
		{
			$relatedlist = (strlen(TagHelper::decode(\Contao\Input::get('related')))) ? preg_split("/,/", TagHelper::decode(\Contao\Input::get('related'))) : array();
			$alltags = array_merge(array(TagHelper::decode(\Contao\Input::get('tag'))), $relatedlist);
			$first = true;
			foreach ($alltags as $tag)
			{
				if (strlen(trim($tag)))
				{
					if (count($tagids))
					{
						$tagids = Database::getInstance()->prepare("SELECT tid FROM tl_tag WHERE from_table = ? AND tag = ? AND tid IN (" . implode(",", $tagids) . ")")
							->execute('tl_faq', $tag)
							->fetchEach('tid');
					}
					else if ($first)
					{
						$tagids = Database::getInstance()->prepare("SELECT tid FROM tl_tag WHERE from_table = ? AND tag = ?")
							->execute('tl_faq', $tag)
							->fetchEach('tid');
						$first = false;
					}
				}
			}
			if (count($tagids) == 0)
			{
				$this->Template->faq = array();
				return;
			}
		}

		$objFaqs = TagsFaqModel::findPublishedByPidsAndIds($this->faq_categories, $tagids);

		if ($objFaqs === null)
		{
			$this->Template->faq = array();

			return;
		}

		$tags = array();
		$arrFaq = array_fill_keys($this->faq_categories, array());

		// Add FAQs
		while ($objFaqs->next())
		{
			$objFaq = $objFaqs->current();

			$arrTemp = $objFaq->row();
			$arrTemp['title'] = StringUtil::specialchars($objFaq->question, true);
			$arrTemp['href'] = $this->generateFaqLink($objFaq);

			if (($objPid = FaqCategoryModel::findById($objFaq->pid)) && empty($arrFaq[$objFaq->pid]))
			{
				$arrFaq[$objFaq->pid] = $objPid->row();
			}

			$arrFaq[$objFaq->pid]['items'][] = $arrTemp;

			$tags[] = 'contao.db.tl_faq.' . $objFaq->id;
		}

		// Tag the FAQs (see #2137)
		if (System::getContainer()->has('fos_http_cache.http.symfony_response_tagger'))
		{
			$responseTagger = System::getContainer()->get('fos_http_cache.http.symfony_response_tagger');
			$responseTagger->addTags($tags);
		}

		$arrFaq = array_values(array_filter($arrFaq));

		$cat_count = 0;
		$cat_limit = \count($arrFaq);

		// Add classes
		foreach ($arrFaq as $k=>$v)
		{
			$count = 0;
			$limit = \count($v['items']);

			for ($i=0; $i<$limit; $i++)
			{
				$arrFaq[$k]['items'][$i]['class'] = trim(((++$count == 1) ? ' first' : '') . (($count >= $limit) ? ' last' : '') . ((($count % 2) == 0) ? ' odd' : ' even'));
			}

			$arrFaq[$k]['class'] = trim(((++$cat_count == 1) ? ' first' : '') . (($cat_count >= $cat_limit) ? ' last' : '') . ((($cat_count % 2) == 0) ? ' odd' : ' even'));
		}

		$this->Template->faq = $arrFaq;
	}

}

