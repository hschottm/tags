<?php

/**
 * @copyright  Helmut Schottmüller 2008-2013
 * @author     Helmut Schottmüller <https://github.com/hschottm/tags_members>
 * @package    tags_members
 * @license    LGPL
 * @filesource
 */

class tl_member_tags extends tl_member
{
	public function deleteMember($dc)
	{
		$this->Database->prepare("DELETE FROM tl_tag WHERE from_table = ? AND tid = ?")
			->execute($dc->table, $dc->id);
	}

	public function onCopy($dc = null)
	{
		if (is_object($dc))
		{
			if (is_array($this->Session->get('tl_member_copy')))
			{
				foreach ($this->Session->get('tl_member_copy') as $data)
				{
					$this->Database->prepare("INSERT INTO tl_tag (tid, tag, from_table) VALUES (?, ?, ?)")
						->execute($dc->id, $data['tag'], $data['table']);
				}
			}
			$this->Session->set('tl_member_copy', null);
			if ($this->Input->get('act') != 'copy')
			{
				return;
			}
			$objTags = $this->Database->prepare("SELECT * FROM tl_tag WHERE tid = ? AND from_table = ?")
				->execute($this->Input->get('id'), $dc->table);
			$tags = array();
			while ($objTags->next())
			{
				array_push($tags, array("table" => $dc->table, "tag" => $objTags->tag));
			}
			$this->Session->set("tl_member_copy", $tags);
		}
	}
}

/**
 * Change tl_member palettes
 */
$disabledObjects = deserialize($GLOBALS['TL_CONFIG']['disabledTagObjects'], true);
if (!in_array('tl_member', $disabledObjects))
{
	$GLOBALS['TL_DCA']['tl_member']['config']['ondelete_callback'][] = array('tl_member_tags', 'deleteMember');
	$GLOBALS['TL_DCA']['tl_member']['config']['onload_callback'][] = array('tl_member_tags', 'onCopy');
	$GLOBALS['TL_DCA']['tl_member']['palettes']['default'] = str_replace("{address_legend", "{categories_legend},tags;{address_legend", $GLOBALS['TL_DCA']['tl_member']['palettes']['default']);
}

$GLOBALS['TL_DCA']['tl_member']['fields']['tags'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['MSC']['tags'],
	'inputType'               => 'tag',
	'eval'                    => array('tl_class'=>'clr long', 'feEditable' => true, 'feGroup' => 'personal'),
	'sql'                     => "char(1) NOT NULL default ''"
);
