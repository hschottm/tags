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
 * @package    Backend
 * @license    LGPL
 * @filesource
 */

namespace Contao;

/**
 * Class TagField
 *
 * Provide methods to handle tag input fields.
 * @copyright  Helmut Schottmüller 2008
 * @author     Helmut Schottmüller <typolight@aurealis.de>
 * @package    Controller
 */
class TagField extends \TextField
{
	protected $blnSubmitInput = FALSE;
	protected $strTagTable = "";
	protected $intMaxTags = 0;

	/**
	 * Save tags to database
	 * @param string
	 * @return string
	 */
	protected function saveTags($value)
	{
		if (!$this->blnSubmitInput)
		{
			$this->import('Database');
			$this->Database->prepare("DELETE FROM tl_tag WHERE from_table = ? AND tid = ?")
				->execute($this->table, $this->activeRecord->id);
			$tags = array_filter(trimsplit(",", $value), 'strlen');
			foreach ($tags as $tag)
			{
				$this->Database->prepare("INSERT INTO tl_tag (tid, tag, from_table) VALUES (?, ?, ?)")
					->execute($this->activeRecord->id, $tag, $this->table);
			}
			return "";
		}
		else return $value;
	}

	/**
	 * Read tags from database
	 * @return string
	 */
	protected function readTags()
	{
		$arrTags = array();
		$tags = \TagModel::findByIdAndTable($this->activeRecord->id, $this->table);
		if ($tags)
		{
			while ($tags->next())
			{
				array_push($arrTags, $tags->tag);
			}
		}
		return count($arrTags) ? implode(",", $arrTags) : '';
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
			case 'isTag':
				$this->blnSubmitInput = !$varValue;
				break;
			case 'table':
				$this->strTagTable = $varValue;
				break;
			case 'value':
				$this->varValue = implode(",", array_filter(trimsplit(",", $varValue), 'strlen'));
				break;
			case 'maxtags':
				$this->intMaxTags = $varValue;
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
			case 'isTag':
				return !$this->blnSubmitInput;
				break;
			case 'table':
				return strlen($this->strTagTable) ? $this->strTagTable : $this->strTable;
				break;
			case 'value':
				return $this->varValue;
				break;
			case 'maxtags':
				return $this->intMaxTags;
				break;

			default:
				return parent::__get($strKey);
				break;
		}
	}

	/**
	 * Generate the widget and return it as string
	 * @return string
	 */
	public function generate()
	{
		$taglist = new TagList($this->table);
		$taglist->maxtags = $this->intMaxTags;
		$tags = $taglist->getTagList();
		$list = '<div class="tags"><ul class="cloud">';
		foreach ($tags as $tag)
		{
			$list .= '<li class="' . $tag['tag_class'] . '">';
			$list .= '<a href="javascript:Tag.selectedTag(\'' . $tag['tag_name'] . '\', \'ctrl_' . $this->strId . '\');" title="' . $tag['tag_name'] . ' (' . $tag['tag_count'] . ')' . '">' . $tag['tag_name'] . '</a>';
			$list .= '</li> ';
		}
		$list .= '</ul></div>';
		$value = (!$this->blnSubmitInput) ? $this->readTags() : $this->varValue;
		return sprintf($list.'<input type="text" name="%s" id="ctrl_%s" class="tl_text%s" value="%s"%s onfocus="Backend.getScrollOffset();" />',
						$this->strName,
						$this->strId,
						(strlen($this->strClass) ? ' ' . $this->strClass : ''),
						specialchars($value),
						$this->getAttributes());
	}

	/**
	 * Validate input and set value
	 */
	public function validate()
	{
		$varInput = $this->validator(deserialize($this->getPost($this->strName)));
		$this->saveTags(implode(",", array_filter(trimsplit(",", $varInput), 'strlen')));
		parent::validate();
	}
}

?>