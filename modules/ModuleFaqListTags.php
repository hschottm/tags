<?php

namespace Contao;

/**
 * Contao Open Source CMS - tags extension
 *
 * Copyright (c) 2008-2016 Helmut Schottmüller
 *
 * @license LGPL-3.0+
 */

class ModuleFaqListTags extends \ModuleFaqList
{

	/**
	 * Generate the module
	 */
	protected function compile()
	{
		$tagids = array();
		if (strlen(\TagHelper::decode(\Input::get('tag'))))
		{
			$relatedlist = (strlen(\TagHelper::decode(\Input::get('related')))) ? preg_split("/,/", \TagHelper::decode(\Input::get('related'))) : array();
			$alltags = array_merge(array(\TagHelper::decode(\Input::get('tag'))), $relatedlist);
			$first = true;
			foreach ($alltags as $tag)
			{
				if (strlen(trim($tag)))
				{
					if (count($tagids))
					{
						$tagids = $this->Database->prepare("SELECT tid FROM tl_tag WHERE from_table = ? AND tag = ? AND tid IN (" . implode(",", $tagids) . ")")
							->execute('tl_faq', $tag)
							->fetchEach('tid');
					}
					else if ($first)
					{
						$tagids = $this->Database->prepare("SELECT tid FROM tl_tag WHERE from_table = ? AND tag = ?")
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

		$objFaq = \TagsFaqModel::findPublishedByPidsAndIds($this->faq_categories, $tagids);

		if ($objFaq === null)
		{
			$this->Template->faq = array();

			return;
		}

		$tags = array();
		$arrFaq = array_fill_keys($this->faq_categories, array());

		// Add FAQs
		while ($objFaq->next())
		{
			$arrTemp = $objFaq->row();
			$arrTemp['title'] = StringUtil::specialchars($objFaq->question, true);
			$arrTemp['href'] = $this->generateFaqLink($objFaq);

			/** @var FaqCategoryModel $objPid */
			$objPid = $objFaq->getRelated('pid');

			$arrFaq[$objFaq->pid]['items'][] = $arrTemp;
			$arrFaq[$objFaq->pid]['headline'] = $objPid->headline;
			$arrFaq[$objFaq->pid]['title'] = $objPid->title;

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

