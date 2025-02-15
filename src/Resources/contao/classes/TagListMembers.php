<?php

/**
 * @copyright  Helmut Schottmüller 2008-2024
 * @author     Helmut Schottmüller <https://github.com/hschottm/tags_members>
 * @package    Backend
 * @license    LGPL
 * @filesource
 */

 namespace Hschottm\TagsBundle;

 use Contao\Database;
 use Contao\System;
 use Contao\StringUtil;

/**
 * Class TagListMembers
 *
 * Provide methods to handle tag input fields.
 * @copyright  Helmut Schottmüller 2008-2024
 * @author     Helmut Schottmüller <https://github.com/hschottm/tags_members>
 * @package    Controller
 */
class TagListMembers extends TagList
{
	protected $arrMembergroups = array();

  public function getRelatedTagList($for_tags, $blnExcludeUnpublishedItems = true)
	{
		if (!is_array($for_tags)) return array();
		if (!count($this->arrMembergroups)) return array();

		$request = System::getContainer()->get('request_stack')->getCurrentRequest();
		if ($request && System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest($request))
		{
			$blnExcludeUnpublishedItems = false;
		}

		$ids = array();
		for ($i = 0; $i < count($for_tags); $i++)
		{
			$arr = Database::getInstance()->prepare("SELECT DISTINCT tl_tag.tid FROM tl_tag, tl_member WHERE tl_tag.tid = tl_member.id AND from_table = ? AND tag = ? ORDER BY tl_tag.tid ASC")
				->execute('tl_member', $for_tags[$i])
				->fetchEach('tid');
			if ($i == 0)
			{
				$ids = $arr;
			}
			else
			{
				$ids = array_intersect($ids, $arr);
			}
		}

		$arrCloudTags = array();
		if (count($ids))
		{
			$objTags = Database::getInstance()->prepare("SELECT tag, COUNT(tag) as count FROM tl_tag, tl_member WHERE tl_tag.tid = tl_member.id AND from_table = ? AND tl_tag.tid IN (" . implode(",", $ids) . ") GROUP BY tag ORDER BY tag ASC")
				->execute('tl_member');
			$list = "";
			$tags = array();
			if ($objTags->numRows)
			{
				while ($objTags->next())
				{
					if (!in_array($objTags->tag, $for_tags))
					{
						$count = count(Database::getInstance()->prepare("SELECT tl_tag.tid FROM tl_tag, tl_member WHERE tl_tag.tid = tl_member.id AND tag = ? AND from_table = ? AND tl_tag.tid IN (" . implode(",", $ids) . ")")
							->execute($objTags->tag, 'tl_member')
							->fetchAllAssoc());
						\array_push($tags, array('tag_name' => $objTags->tag, 'tag_count' => $count));
					}
				}
			}
			if (count($tags))
			{
				$arrCloudTags = $this->cloud_tags($tags);
			}
		}
		return $arrCloudTags;
	}

  public function getTagList($blnExcludeUnpublishedItems = true)
	{
//		if (count($this->arrCloudTags) == 0)
//		{
			if (count($this->arrMembergroups) > 0)
			{
				$objTags = Database::getInstance()->prepare("SELECT tag, COUNT(tag) as count FROM tl_tag, tl_member WHERE tl_tag.tid = tl_member.id AND from_table = ? GROUP BY tag ORDER BY tag ASC")
					->execute('tl_member');
				$list = "";
				$tags = array();
				if ($objTags->numRows)
				{
					while ($objTags->next())
					{
						//if ($this->isMemberOf($objTags->groups))
						//{
							\array_push($tags, array('tag_name' => $objTags->tag, 'tag_count' => $objTags->count));
						//}
					}
				}

				if (count($tags))
				{
					$this->arrCloudTags = $this->cloud_tags($tags);
				}
			}
//		}
		return $this->arrCloudTags;
	}

	/**
	 * Return true if a user is member of a particular group
	 * @param mixed
	 * @return boolean
	 */
	protected function isMemberOf($taggroups)
	{
		$groups = StringUtil::deserialize($taggroups);

		// No groups assigned
		if (!is_array($groups) || count($groups) < 1)
		{
			return false;
		}

		foreach ($groups as $group)
		{
			// Group ID found
			if (in_array($group, $this->arrMembergroups))
			{
				return true;
			}
		}

		return false;
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
			case 'membergroups':
				$this->arrMembergroups = $varValue;
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
			case 'membergroups':
				return $this->arrMembergroups;
				break;
			default:
				return parent::__get($strKey);
				break;
		}
	}
}
