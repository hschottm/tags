<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * @copyright  Helmut Schottmüller <contao@aurealis.de>
 * @author     Helmut Schottmüller <contao@aurealis.de>
 * @package    Backend
 * @license    LGPL
 * @filesource
 */


/**
 * Table tl_content
 */

$disabledObjects = deserialize($GLOBALS['TL_CONFIG']['disabledTagObjects'], true);
if (!in_array('tl_content', $disabledObjects))
{
	foreach ($GLOBALS['TL_DCA']['tl_content']['palettes'] as $key => $palette)
	{
		if (strcmp($key, '__selector__') != 0)
		{
			$pos = strpos($GLOBALS['TL_DCA']['tl_content']['palettes'][$key], '{', 2);
			if ($pos !== FALSE)
			{
				$GLOBALS['TL_DCA']['tl_content']['palettes'][$key] = substr($GLOBALS['TL_DCA']['tl_content']['palettes'][$key],0,$pos) . "{tags_legend:hide},tags;" . substr($GLOBALS['TL_DCA']['tl_content']['palettes'][$key],$pos);
			}
		}
	}

	$GLOBALS['TL_DCA']['tl_content']['palettes']['headline'] = str_replace('guests','guests,tagsonly', $GLOBALS['TL_DCA']['tl_content']['palettes']['headline']);
	$GLOBALS['TL_DCA']['tl_content']['config']['ondelete_callback'][] = array('tl_content_tags', 'removeContentElement');
	$GLOBALS['TL_DCA']['tl_content']['config']['onload_callback'][] = array('tl_content_tags', 'onCopy');
}

$GLOBALS['TL_DCA']['tl_content']['fields']['tagsonly'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['tagsonly'],
	'inputType'               => 'checkbox'
);

$GLOBALS['TL_DCA']['tl_content']['fields']['tags'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['MSC']['tags'],
	'inputType'               => 'tag',
	'eval'                    => array('tl_class'=>'clr long')
);

/**
 * Class tl_content_tags
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  Helmut Schottmüller 2009
 * @author     Helmut Schottmüller <typolight@aurealis.de>
 * @package    Controller
 */
class tl_content_tags extends tl_content
{
	public function removeContentElement($dc)
	{
		$this->Database->prepare("DELETE FROM tl_tag WHERE from_table = ? AND id = ?")
			->execute($dc->table, $dc->id);
	}

	public function onCopy($dc)
	{
		if (is_array($this->Session->get('tl_content_copy')))
		{
			foreach ($this->Session->get('tl_content_copy') as $data)
			{
				$this->Database->prepare("INSERT INTO tl_tag (id, tag, from_table) VALUES (?, ?, ?)")
					->execute($dc->id, $data['tag'], $data['table']);
			}
		}
		$this->Session->set('tl_content_copy', null);
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
		$this->Session->set("tl_content_copy", $tags);
	}
}

?>