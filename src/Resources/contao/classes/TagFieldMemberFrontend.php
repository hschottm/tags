<?php

/**
 * @copyright  Helmut Schottmüller 2008-2024
 * @author     Helmut Schottmüller <https://github.com/hschottm/tags_members>
 * @package    Backend
 * @license    LGPL
 * @filesource
 */

namespace Hschottm\TagsBundle;

use \Contao\FormText;
use \Contao\Database;
use \Contao\FrontendUser;

/**
 * Class TagFieldFrontend
 *
 * Provide methods to handle tag input fields.
 * @copyright  Helmut Schottmüller 2008-2024
 * @author     Helmut Schottmüller <https://github.com/hschottm/tags_members>
 * @package    Controller
 */
class TagFieldMemberFrontend extends FormText
{
	protected $blnSubmitInput = true;
	protected $strTagTable = "";
	protected $intMaxTags = 0;
	private bool $renderingTagInput = false;

	/**
	 * Save tags to database
	 * @param string
	 * @return string
	 */
	protected function saveTags($value)
	{
		if ($this->blnSubmitInput && FrontendUser::getInstance()->id)
		{
			$user = FrontendUser::getInstance();
			Database::getInstance()->prepare("DELETE FROM tl_tag WHERE from_table = ? AND tid = ?")
				->execute('tl_member', $user->id);
			$tags = array_filter(\Contao\StringUtil::trimsplit(",", $value), 'strlen');
			foreach ($tags as $tag)
			{
				Database::getInstance()->prepare("INSERT INTO tl_tag (tid, tag, from_table) VALUES (?, ?, ?)")
					->execute($user->id, $tag, 'tl_member');
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
		$user = FrontendUser::getInstance();
		$arrTags = Database::getInstance()->prepare("SELECT tag FROM tl_tag WHERE tid = ? AND from_table = ? ORDER BY tag ASC")
			->execute($user->id, 'tl_member')
			->fetchEach('tag');
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
				$this->varValue = implode(",", array_filter(\Contao\StringUtil::trimsplit(",", (string) $varValue), 'strlen'));
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
				return $this->renderingTagInput ? parent::__get($strKey) : '';
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
		$GLOBALS['TL_JAVASCRIPT'][] = 'bundles/hschottmtags/js/tag.js';
		$taglist = new TagList('tl_member');
		$taglist->maxtags = $this->intMaxTags;
		$tags = $taglist->getTagList();
		$list = '<div class="tags"><ul class="cloud">';
		foreach ($tags as $tag)
		{
			$list .= '<li class="' . $tag['tag_class'] . '">';
			$list .= '<a href="#" data-tag-target="ctrl_' . \Contao\StringUtil::specialchars($this->strId) . '" data-tag="' . \Contao\StringUtil::specialchars($tag['tag_name']) . '" title="' . \Contao\StringUtil::specialchars($tag['tag_name'] . ' (' . $tag['tag_count'] . ')') . '">' . \Contao\StringUtil::specialchars($tag['tag_name']) . '</a>';
			$list .= '</li> ';
		}
		$list .= '</ul></div>';
		// Render through the installed Contao parent, keeping its escaping, attributes
		// and markup current. Display values must not change the persistence value.
		$previousValue = $this->varValue;
		$previousRendering = $this->renderingTagInput;
		try {
			$this->varValue = $this->hasErrors() ? $previousValue : $this->readTags();
			$this->renderingTagInput = true;
			return $list . parent::generate();
		} finally {
			$this->varValue = $previousValue;
			$this->renderingTagInput = $previousRendering;
		}
	}

	/**
	 * Validate input and set value
	 */
	public function validate()
	{
        parent::validate();
        if (!$this->hasErrors()) {
            $this->saveTags((string) $this->varValue);
        }
	}
}
