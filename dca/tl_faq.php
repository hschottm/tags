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

if (@class_exists("tl_faq"))
{
	/**
	 * Change tl_faq default palette
	 */

	$disabledObjects = deserialize($GLOBALS['TL_CONFIG']['disabledTagObjects'], true);
	if (!in_array('tl_article', $disabledObjects))
	{
		$GLOBALS['TL_DCA']['tl_faq']['palettes']['default'] = str_replace("author", "author,tags", $GLOBALS['TL_DCA']['tl_faq']['palettes']['default']);
		$GLOBALS['TL_DCA']['tl_faq']['config']['ondelete_callback'][] = array('tl_faq_tags', 'removeFAQ');
		$GLOBALS['TL_DCA']['tl_faq']['config']['onload_callback'][] = array('tl_faq_tags', 'onCopy');
	}

	$GLOBALS['TL_DCA']['tl_faq']['fields']['tags'] = array
	(
		'label'                   => &$GLOBALS['TL_LANG']['MSC']['tags'],
		'inputType'               => 'tag',
		'eval'                    => array('tl_class'=>'clr long')
	);

	class tl_faq_tags extends tl_faq
	{
		public function removeFAQ($dc)
		{
			$this->Database->prepare("DELETE FROM tl_tag WHERE from_table = ? AND id = ?")
				->execute($dc->table, $dc->id);
		}

		public function onCopy($dc)
		{
			if (is_array($this->Session->get('tl_faq_copy')))
			{
				foreach ($this->Session->get('tl_faq_copy') as $data)
				{
					$this->Database->prepare("INSERT INTO tl_tag (id, tag, from_table) VALUES (?, ?, ?)")
						->execute($dc->id, $data['tag'], $data['table']);
				}
			}
			$this->Session->set('tl_faq_copy', null);
			if (\Input::get('act') != 'copy')
			{
				return;
			}
			$objTags = $this->Database->prepare("SELECT * FROM tl_tag WHERE id = ? AND from_table = ?")
				->execute(\Input::get('id'), $dc->table);
			$tags = array();
			while ($objTags->next())
			{
				array_push($tags, array("table" => $dc->table, "tag" => $objTags->tag));
			}
			$this->Session->set("tl_faq_copy", $tags);
		}
	}

}

?>