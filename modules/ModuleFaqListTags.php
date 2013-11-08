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
 * @copyright  Helmut Schottmüller 2012
 * @author     Helmut Schottmüller <contao@aurealis.de>
 * @package    Faq
 * @license    LGPL
 * @filesource
 */

namespace Contao;

if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Class ModuleFaqListTags
 *
 * @copyright  Helmut Schottmüller 2012
 * @author     Helmut Schottmüller <contao@aurealis.de>
 * @package    Controller
 */
class ModuleFaqListTags extends \ModuleFaqList
{

	/**
	 * Generate module
	 */
	protected function compile()
	{
		$tagids = array();
		if (strlen(\Input::get('tag')))
		{
			$relatedlist = (strlen(\Input::get('related'))) ? preg_split("/,/", \Input::get('related')) : array();
			$alltags = array_merge(array(\Input::get('tag')), $relatedlist);
			$first = true;
			foreach ($alltags as $tag)
			{
				if (strlen(trim($tag)))
				{
					if (count($tagids))
					{
						$tagids = $this->Database->prepare("SELECT tid FROM tl_tag WHERE from_table = ? AND tag = ? AND tid IN (" . join($tagids, ",") . ")")
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

		$arrFaq = array_fill_keys($this->faq_categories, array());

		// Add FAQs
		while ($objFaq->next())
		{
			$arrTemp = $objFaq->row();

			$arrTemp['title'] = specialchars($objFaq->question, true);
			$arrTemp['href'] = $this->generateFaqLink($objFaq);

			$arrFaq[$objFaq->pid]['items'][] = $arrTemp;
			$arrFaq[$objFaq->pid]['headline'] = $objFaq->getRelated('pid')->headline;
		}

		$arrFaq = array_values(array_filter($arrFaq));

		$cat_count = 0;
		$cat_limit = count($arrFaq);

		// Add classes
		foreach ($arrFaq as $k=>$v)
		{
			$count = 0;
			$limit = count($v['items']);

			for ($i=0; $i<$limit; $i++)
			{
				$arrFaq[$k]['items'][$i]['class'] = trim(((++$count == 1) ? ' first' : '') . (($count >= $limit) ? ' last' : '') . ((($count % 2) == 0) ? ' odd' : ' even'));
			}

			$arrFaq[$k]['class'] = trim(((++$cat_count == 1) ? ' first' : '') . (($cat_count >= $cat_limit) ? ' last' : '') . ((($cat_count % 2) == 0) ? ' odd' : ' even'));
		}

		$this->Template->faq = $arrFaq;
	}
}

?>