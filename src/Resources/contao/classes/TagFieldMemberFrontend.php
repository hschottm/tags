<?php

/**
 * @copyright  Helmut Schottmüller 2008-2024
 * @author     Helmut Schottmüller <https://github.com/hschottm/tags_members>
 * @package    Backend
 * @license    LGPL
 * @filesource
 */

namespace Hschottm\TagsBundle;

use \Contao\FormTextField;
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
class TagFieldMemberFrontend extends FormTextField
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
			$user = FrontendUser::getInstance();
			Database::getInstance()->prepare("DELETE FROM tl_tag WHERE from_table = ? AND tid = ?")
				->execute('tl_member', $user->id);
			$tags = array_filter(\Contao\StringUtil::trimsplit(",", $value), 'strlen');
			foreach ($tags as $tag)
			{
				Database::getInstance()->prepare("INSERT INTO tl_tag (tid, tag, from_table) VALUES (?, ?, ?)")
					->execute($ser->id, $tag, 'tl_member');
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
				$this->varValue = implode(",", array_filter(\Contao\StringUtil::trimsplit(",", $varValue), 'strlen'));
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
		/**
		 * JavaScript files
		 */
		if (is_array($GLOBALS['TL_JAVASCRIPT']))
		{
			\Contao\ArrayUtil::arrayInsert($GLOBALS['TL_JAVASCRIPT'], 1, 'system/modules/tags/assets/tag.js');
		}
		else
		{
			$GLOBALS['TL_JAVASCRIPT'] = array('system/modules/tags/assets/tag.js');
		}
		$taglist = new TagList('tl_member');
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
		return sprintf($list.'<input type="%s" name="%s" id="ctrl_%s" class="text%s%s" value="%s"%s%s',
						$this->type,
						$this->strName,
						$this->strId,
						($this->hideInput ? ' password' : ''),
						(($this->strClass != '') ? ' ' . $this->strClass : ''),
						\Contao\StringUtil::specialchars($this->value),
						$this->getAttributes(),
						$this->strTagEnding) . $this->addSubmit();
	}

	/**
	 * Validate input and set value
	 */
	public function validate()
	{
		$varInput = $this->validator(\Contao\StringUtil::deserialize($this->getPost($this->strName)));
		$this->saveTags(implode(",", array_filter(\Contao\StringUtil::trimsplit(",", $varInput), 'strlen')));
		parent::validate();
	}
}
