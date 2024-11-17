<?php

/**
* @copyright  Helmut Schottmüller 2008-2024
* @author     Helmut Schottmüller <https://github.com/hschottm/tags_members>
 * @package    CalendarImport
 * @license    LGPL
 */

namespace Hschottm\TagsBundle;

use \Contao\Backend;
use \Contao\Database;

/**
 * Class TagMemberHelper
 *
 * Provide methods to handle tags_member hooks
 * @copyright  Helmut Schottmüller 2008-2024
 * @author     Helmut Schottmüller <https://github.com/hschottm/tags_members>
 * @package    Controller
 */
class TagMemberHelper extends Backend
{
	public function setMemberlistOptions($moduleMemberList)
	{
		if (strlen(TagHelper::decode(\Contao\Input::get('tag'))))
		{
			$relatedlist = (strlen(TagHelper::decode(\Contao\Input::get('related')))) ? preg_split("/,/", TagHelper::decode(\Contao\Input::get('related'))) : array();
			$alltags = array_merge(array(TagHelper::decode(\Contao\Input::get('tag'))), $relatedlist);
			$tagids = array();
			$first = true;
			foreach ($alltags as $tag)
			{
				if (strlen(trim($tag)))
				{
					if (count($tagids))
					{
						$tagids = Database::getInstance()->prepare("SELECT tid FROM tl_tag WHERE from_table = ? AND tag = ? AND  tid IN (" . implode(",", $tagids) . ")")
							->execute('tl_member', $tag)
							->fetchEach('tid');
					}
					else if ($first)
					{
						$tagids = Database::getInstance()->prepare("SELECT tid FROM tl_tag WHERE from_table = ? AND tag = ?")
							->execute('tl_member', $tag)
							->fetchEach('tid');
						$first = false;
					}
				}
			}
			$arrValidMembers = $tagids;
			if (count($arrValidMembers) > 0)
			{
				return array("tl_member.id IN (" . implode(',', $arrValidMembers) . ")");
			}
			else
			{
				return array();
			}
		}
		return array();
	}
}
