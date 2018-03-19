<?php

/**
 * @copyright  Helmut Schottmüller 2008-2013
 * @author     Helmut Schottmüller <https://github.com/hschottm/tags_members>
 * @package    Backend
 * @license    LGPL
 * @filesource
 */

namespace Contao;

/**
 * Class TagListMembers
 *
 * Provide methods to handle tag input fields.
 * @copyright  Helmut Schottmüller 2008-2013
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

    if (TL_MODE == 'BE')
		{
			$blnExcludeUnpublishedItems = false;
		}

		$ids = array();
		for ($i = 0; $i < count($for_tags); $i++)
		{
			$arr = $this->Database->prepare("SELECT DISTINCT tl_tag.tid FROM tl_tag, tl_member WHERE tl_tag.tid = tl_member.id AND from_table = ? AND tag = ? ORDER BY tl_tag.tid ASC")
				->execute(array('tl_member', $for_tags[$i]))
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
			$objTags = $this->Database->prepare("SELECT tag, COUNT(tag) as count FROM tl_tag, tl_member WHERE tl_tag.tid = tl_member.id AND from_table = ? AND tl_tag.tid IN (" . join($ids, ",") . ") GROUP BY tag ORDER BY tag ASC")
				->execute('tl_member');
			$list = "";
			$tags = array();
			if ($objTags->numRows)
			{
				while ($objTags->next())
				{
					if (!in_array($objTags->tag, $for_tags))
					{
						$count = count($this->Database->prepare("SELECT tl_tag.tid FROM tl_tag, tl_member WHERE tl_tag.tid = tl_member.id AND tag = ? AND from_table = ? AND tl_tag.tid IN (" . join($ids, ",") . ")")
							->execute($objTags->tag, 'tl_member')
							->fetchAllAssoc());
						array_push($tags, array('tag_name' => $objTags->tag, 'tag_count' => $count));
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
		if (count($this->arrCloudTags) == 0)
		{
			if (count($this->arrMembergroups) > 0)
			{
				$objTags = $this->Database->prepare("SELECT tag, COUNT(tag) as count, tl_member.groups FROM tl_tag, tl_member WHERE tl_tag.tid = tl_member.id AND from_table = ? GROUP BY tag ORDER BY tag ASC")
					->execute('tl_member');
				$list = "";
				$tags = array();
				if ($objTags->numRows)
				{
					while ($objTags->next())
					{
						if ($this->isMemberOf($objTags->groups))
						{
							array_push($tags, array('tag_name' => $objTags->tag, 'tag_count' => $objTags->count));
						}
					}
				}
				if (count($tags))
				{
					$this->arrCloudTags = $this->cloud_tags($tags);
				}
			}
		}
		return $this->arrCloudTags;
	}

	/**
	 * Return true if a user is member of a particular group
	 * @param mixed
	 * @return boolean
	 */
	protected function isMemberOf($taggroups)
	{
		$groups = deserialize($taggroups);

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
