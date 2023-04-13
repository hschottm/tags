<?php

/**
 * @copyright  Helmut Schottmüller 2008-2013
 * @author     Helmut Schottmüller <https://github.com/hschottm/tags_members>
 * @package    tags_members
 * @license    LGPL
 * @filesource
 */

class tl_member_tags extends \Backend
{
	public function deleteMember(\DataContainer $dc, $undoId)
	{
		$this->Database->prepare("DELETE FROM tl_tag WHERE from_table = ? AND tid = ?")
			->execute($dc->table, $dc->id);
	}

	public function onCopy($insertID, \DataContainer $dc)
	{
		$objTags = $this->Database->prepare("SELECT * FROM tl_tag WHERE tid = ? AND from_table = ?")->execute($dc->id, $dc->table);
		$tags = array();
		while ($objTags->next()) {
			\array_push($tags, array("table" => $dc->table, "tag" => $objTags->tag));
		}
		foreach ($tags as $entry) {
			$this->Database->prepare("INSERT INTO tl_tag (tid, tag, from_table) VALUES (?, ?, ?)")->execute($insertID, $entry['tag'], $entry['table']);
		}
	}
}

/**
 * Change tl_member palettes
 */
if (isset($GLOBALS['TL_CONFIG']['disabledTagObjects'])) {
	$disabledObjects = deserialize($GLOBALS['TL_CONFIG']['disabledTagObjects'], true);
} else {
	$disabledObjects = array();
}
if (!in_array('tl_member', $disabledObjects))
{
	$GLOBALS['TL_DCA']['tl_member']['config']['ondelete_callback'][] = array('tl_member_tags', 'deleteMember');
	$GLOBALS['TL_DCA']['tl_member']['config']['oncopy_callback'][] = array('tl_member_tags', 'onCopy');
	if (array_key_exists('tl_member', $GLOBALS['TL_DCA'])) {
		$GLOBALS['TL_DCA']['tl_member']['palettes']['default'] = str_replace("{address_legend", "{categories_legend},tags;{address_legend", $GLOBALS['TL_DCA']['tl_member']['palettes']['default']);
	}
}

$GLOBALS['TL_DCA']['tl_member']['fields']['tags'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['MSC']['tags'],
	'inputType'               => 'tag',
	'eval'                    => array('tl_class'=>'clr long', 'feEditable' => true, 'feGroup' => 'personal'),
	'sql'                     => "char(1) NOT NULL default ''"
);
