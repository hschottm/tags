<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

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
 * @author     Helmut Schottmüller <helmut.schottmueller@aurealis.de>
 * @package    tags
 * @license    LGPL
 * @filesource
 */

/**
 * Class tl_module_tags
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  Helmut Schottmüller 2008-2010
 * @author     Helmut Schottmüller <contao@aurealis.de>
 * @package    Controller
 */
class tl_module_tags extends tl_module
{
	/**
	 * Return available tag tables
	 *
	 * @return array Array of tag tables
	 */
	public function getTagTables()
	{
		$objTable = $this->Database->prepare("SELECT DISTINCT(from_table) FROM tl_tag ORDER BY from_table")
			->execute();
		$tables = array();
		if ($objTable->numRows)
		{
			while ($objTable->next())
			{
				$tables[$objTable->from_table] = $objTable->from_table;
			}
		}
		return $tables;
	}
	
	public function getObjectTypes()
	{
		return array(
			'tl_content' => $GLOBALS['TL_LANG']['tl_module']['tl_content'],
			'tl_article' => $GLOBALS['TL_LANG']['tl_module']['tl_article'],
			'tl_page' => $GLOBALS['TL_LANG']['tl_module']['tl_page']
		);
	}
	
	public function getContentObjectTagTables()
	{
		return array(
			'tl_content' => 'tl_content',
			'tl_article' => 'tl_article',
			'tl_page' => 'tl_page'
		);
	}

	/**
	 * Return all articlelist templates as array
	 * @param object
	 * @return array
	 */
	public function getArticleListTemplates(DataContainer $dc)
	{
		return $this->getTemplateGroup('mod_global_', $dc->activeRecord->pid);
	}

	/**
	 * Return all tag cloud templates as array
	 * @param object
	 * @return array
	 */
	public function getTagCloudTemplates(DataContainer $dc)
	{
		return $this->getTemplateGroup('mod_tagcloud', $dc->activeRecord->pid);
	}

	/**
	 * Return all tag scope templates as array
	 * @param object
	 * @return array
	 */
	public function getTagScopeTemplates(DataContainer $dc)
	{
		return $this->getTemplateGroup('mod_tagscope', $dc->activeRecord->pid);
	}
}

/**
 * Add palettes to tl_module
 */
$GLOBALS['TL_DCA']['tl_module']['palettes']['tagcloud']    = '{title_legend},name,headline,type;{size_legend},tag_maxtags,tag_buckets,tag_named_class,tag_show_reset;{template_legend:hide},cloud_template;{tagextension_legend},tag_related,tag_topten;{redirect_legend},tag_jumpTo,keep_url_params;{datasource_legend},tag_sourcetables;{expert_legend:hide},tag_tagtable,tag_tagfield,cssID';
$GLOBALS['TL_DCA']['tl_module']['palettes']['tagscope']    = '{title_legend},name,headline,type;{tagscope_legend},clear_text,show_empty_scope;{template_legend:hide}scope_template;{redirect_legend},tag_jumpTo,keep_url_params';
$GLOBALS['TL_DCA']['tl_module']['palettes']['globalArticleList'] = '{title_legend},name,headline,type;{template_legend:hide},articlelist_template;{showtags_legend},hide_on_empty;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
$GLOBALS['TL_DCA']['tl_module']['palettes']['tagcontentlist'] = '{title_legend},name,headline,type;{object_selection_legend},objecttype,tagsource,pagesource;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
$GLOBALS['TL_DCA']['tl_module']['palettes']['taglistbycategory'] = '{title_legend},name,headline,type;{datasource_legend},tag_sourcetables,pagesource;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
$GLOBALS['TL_DCA']['tl_module']['palettes']['newsreader']  = str_replace('{template_legend', '{showtags_legend},tag_ignore,news_showtags;{template_legend', $GLOBALS['TL_DCA']['tl_module']['palettes']['newsreader']);
$GLOBALS['TL_DCA']['tl_module']['palettes']['newsarchive']  = str_replace('{template_legend', '{showtags_legend},tag_ignore,news_showtags;{template_legend', $GLOBALS['TL_DCA']['tl_module']['palettes']['newsarchive']);
$GLOBALS['TL_DCA']['tl_module']['palettes']['newslist']  = str_replace('{template_legend', '{showtags_legend},tag_ignore,news_showtags;{template_legend', $GLOBALS['TL_DCA']['tl_module']['palettes']['newslist']);
$GLOBALS['TL_DCA']['tl_module']['palettes']['eventlist']  = str_replace('{template_legend', '{showtags_legend},tag_ignore;{template_legend', $GLOBALS['TL_DCA']['tl_module']['palettes']['eventlist']);
$GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'][] = 'tag_topten';
$GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'][] = 'news_showtags';
$GLOBALS['TL_DCA']['tl_module']['subpalettes']['tag_topten']    = 'tag_topten_expanded,tag_all_expanded';
$GLOBALS['TL_DCA']['tl_module']['subpalettes']['news_showtags']    = 'tag_jumpTo,tag_named_class';

/**
 * Add fields to tl_module
 */

$GLOBALS['TL_DCA']['tl_module']['fields']['tag_sourcetables'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['tag_forTable'],
	'inputType'               => 'checkbox',
	'options_callback'        => array('tl_module_tags', 'getTagTables'),
	'eval'                    => array('multiple'=>true, 'tl_class' => 'full')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['hide_on_empty'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['hide_on_empty'],
	'inputType'               => 'checkbox',
	'eval'                    => array('multiple'=>false, 'tl_class' => 'w50 m12')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['tag_tagtable'] = array
(
	'label'              => &$GLOBALS['TL_LANG']['tl_module']['tag_tagtable'],
	'default'            => 'tl_tag',
	'inputType'          => 'text',
	'eval'               => array('maxlength'=>100)
);

$GLOBALS['TL_DCA']['tl_module']['fields']['tag_filter'] = array
(
	'label'              => &$GLOBALS['TL_LANG']['tl_module']['tag_filter'],
	'inputType'          => 'text',
	'eval'               => array('maxlength'=>255, 'tl_class' => 'w50')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['tag_tagfield'] = array
(
	'label'              => &$GLOBALS['TL_LANG']['tl_module']['tag_tagfield'],
	'default'            => 'tag',
	'inputType'          => 'text',
	'eval'               => array('maxlength'=>100)
);

$GLOBALS['TL_DCA']['tl_module']['fields']['tag_maxtags'] = array
(
	'label'              => &$GLOBALS['TL_LANG']['tl_module']['tag_maxtags'],
	'default'            => '0',
	'inputType'          => 'text',
	'eval'               => array('maxlength'=>5, 'rgxp' => 'digit', 'tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['tag_buckets'] = array
(
	'label'              => &$GLOBALS['TL_LANG']['tl_module']['tag_buckets'],
	'default'            => '4',
	'inputType'          => 'text',
	'eval'               => array('maxlength'=>2, 'rgxp' => 'digit', 'tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['tag_named_class'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['tag_named_class'],
	'inputType'               => 'checkbox',
	'eval'                    => array('tl_class' => 'w50 m12')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['tag_on_page_class'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['tag_on_page_class'],
	'inputType'               => 'checkbox',
	'eval'                    => array('tl_class' => 'w50 m12')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['keep_url_params'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['keep_url_params'],
	'inputType'               => 'checkbox',
	'eval'                    => array('tl_class' => 'w50 m12')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['tag_topten'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['tag_topten'],
	'inputType'               => 'checkbox',
	'eval'                    => array('submitOnChange'=>true)
);

$GLOBALS['TL_DCA']['tl_module']['fields']['tag_related'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['tag_related'],
	'inputType'               => 'checkbox',
	'eval'                    => array()
);

$GLOBALS['TL_DCA']['tl_module']['fields']['tag_topten_expanded'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['tag_topten_expanded'],
	'inputType'               => 'checkbox'
);

$GLOBALS['TL_DCA']['tl_module']['fields']['tag_all_expanded'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['tag_all_expanded'],
	'inputType'               => 'checkbox'
);

$GLOBALS['TL_DCA']['tl_module']['fields']['news_showtags'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['news_showtags'],
	'inputType'               => 'checkbox',
	'eval'                    => array('submitOnChange'=>true)
);

$GLOBALS['TL_DCA']['tl_module']['fields']['tag_jumpTo'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['tag_jumpTo'],
	'inputType'               => 'pageTree',
	'explanation'             => 'jumpTo',
	'eval'                    => array('fieldType'=>'radio', 'helpwizard'=>true)
);

$GLOBALS['TL_DCA']['tl_module']['fields']['tag_ignore'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['tag_ignore'],
	'inputType'               => 'checkbox',
	'eval'                    => array('tl_class' => 'w50')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['objecttype'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['objecttype'],
	'filter'                  => true,
	'inputType'               => 'select',
	'options_callback'        => array('tl_module_tags', 'getObjectTypes'),
	'eval'                    => array('submitOnChange'=>false, 'tl_class'=>'w50', 'mandatory' => true)
);

$GLOBALS['TL_DCA']['tl_module']['fields']['tagsource'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['tagsource'],
	'filter'                  => true,
	'inputType'               => 'select',
	'options_callback'        => array('tl_module_tags', 'getContentObjectTagTables'),
	'eval'                    => array('submitOnChange'=>false, 'tl_class'=>'w50', 'mandatory' => true)
);

$GLOBALS['TL_DCA']['tl_module']['fields']['pagesource'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pagesource'],
	'inputType'               => 'pageTree',
	'eval'                    => array('fieldType'=>'radio', 'helpwizard'=>false, 'mandatory' => true, 'tl_class'=>'clr')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['articlelist_template'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['articlelist_template'],
	'default'                 => 'mod_global_articlelist',
	'exclude'                 => true,
	'inputType'               => 'select',
	'options_callback'        => array('tl_module_tags', 'getArticleListTemplates'),
	'eval'                    => array('tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['cloud_template'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['cloud_template'],
	'default'                 => 'mod_tagcloud',
	'exclude'                 => true,
	'inputType'               => 'select',
	'options_callback'        => array('tl_module_tags', 'getTagCloudTemplates'),
	'eval'                    => array('tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['scope_template'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['scope_template'],
	'default'                 => 'mod_tagscope',
	'exclude'                 => true,
	'inputType'               => 'select',
	'options_callback'        => array('tl_module_tags', 'getTagScopeTemplates'),
	'eval'                    => array('tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['clear_text'] = array
(
	'label'              => &$GLOBALS['TL_LANG']['tl_module']['clear_text'],
	'default'            => &$GLOBALS['TL_LANG']['tl_module']['tags'],
	'inputType'          => 'text',
	'eval'               => array('maxlength'=>128, 'mandatory' => true, 'tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['show_empty_scope'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['show_empty_scope'],
	'inputType'               => 'checkbox',
	'eval'                    => array('tl_class' => 'w50 m12')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['tag_show_reset'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['tag_show_reset'],
	'inputType'               => 'checkbox',
	'eval'                    => array('tl_class' => 'w50 m12')
);

?>