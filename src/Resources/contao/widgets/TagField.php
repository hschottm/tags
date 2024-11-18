<?php

namespace Hschottm\TagsBundle;

use Contao\TextField;
use Contao\Database;
use Contao\StringUtil;

/**
 * Contao Open Source CMS - tags extension
 *
 * Copyright (c) 2008-2024 Helmut Schottmüller
 *
 * @license LGPL-3.0+
 */

class TagField extends TextField
{
	protected $blnSubmitInput = true;
	protected $strTagTable = "";
	protected $intMaxTags = 0;

	/**
	 * Save tags to database
	 * @param string
	 * @return string
	 */
	protected function saveTags($value)
	{
		if ($this->blnSubmitInput)
		{
			Database::getInstance()->prepare("DELETE FROM tl_tag WHERE from_table = ? AND tid = ?")
				->execute($this->table, $this->activeRecord->id);
			$tags = array_filter(StringUtil::trimsplit(",", $value), 'strlen');
			foreach ($tags as $tag)
			{
				Database::getInstance()->prepare("INSERT INTO tl_tag (tid, tag, from_table) VALUES (?, ?, ?)")
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
		$tags = TagModel::findByIdAndTable($this->activeRecord->id, $this->table);
		if ($tags)
		{
			while ($tags->next())
			{
				\array_push($arrTags, $tags->tag);
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
			case 'table':
				$this->strTagTable = $varValue;
				break;
			case 'value':
				$this->varValue = implode(",", array_filter(StringUtil::trimsplit(",", $varValue), 'strlen'));
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
			case 'table':
				return strlen($this->strTagTable) ? $this->strTagTable : $this->strTable;
				break;
			case 'value':
				return '';
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
		$value = $this->readTags();
		return $list.sprintf('<input type="text" name="%s" id="ctrl_%s" class="tl_text%s" value="%s"%s onfocus="Backend.getScrollOffset();" />',
						$this->strName,
						$this->strId,
						(strlen($this->strClass) ? ' ' . $this->strClass : ''),
						StringUtil::specialchars($value),
						$this->getAttributes());
	}

	/**
	 * Validate input and set value
	 */
	public function validate()
	{
		$varInput = $this->validator(StringUtil::deserialize($this->getPost($this->strName)));
		$this->saveTags(implode(",", array_filter(StringUtil::trimsplit(",", $varInput), 'strlen')));
		parent::validate();
	}
}
