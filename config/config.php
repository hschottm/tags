<?php

/**
 * Contao Open Source CMS - tags extension
 *
 * Copyright (c) 2008-2016 Helmut Schottmüller
 *
 * @license LGPL-3.0+
 */

/**
 * Form fields
 */
$GLOBALS['BE_FFL']['tag'] = 'TagField';

/**
 * Front end modules
 */
array_insert($GLOBALS['FE_MOD']['tags'], 1, array
(
	'tagcloud'    => 'ModuleTagCloud'
));
array_insert($GLOBALS['FE_MOD']['tags'], 2, array
(
	'tagscope'    => 'ModuleTagScope'
));
array_insert($GLOBALS['FE_MOD']['miscellaneous'], 3, array
(
	'globalArticleList'    => 'ModuleGlobalArticlelist'
));
array_insert($GLOBALS['FE_MOD']['tags'], 3, array
(
	'tagcontentlist'    => 'ModuleTagContentList'
));
array_insert($GLOBALS['FE_MOD']['tags'], 4, array
(
	'taglistbycategory'    => 'ModuleTagListByCategory'
));

$GLOBALS['FE_MOD']['news']['newslist'] = 'ModuleNewsListTags';
$GLOBALS['FE_MOD']['news']['newsarchive'] = 'ModuleNewsArchiveTags';
$GLOBALS['FE_MOD']['news']['newsreader'] = 'ModuleNewsReaderTags';
$GLOBALS['FE_MOD']['events']['calendar'] = 'ModuleCalendarTags';
$GLOBALS['FE_MOD']['events']['eventlist'] = 'ModuleEventlistTags';
$GLOBALS['FE_MOD']['events']['eventreader'] = 'ModuleEventReaderTags';
$GLOBALS['FE_MOD']['faq']['faqlist'] = 'ModuleFaqListTags';

if (array_key_exists('last_events', $GLOBALS['FE_MOD']['events']))
{
	// add support for last_events extension
	$GLOBALS['FE_MOD']['events']['last_events'] = 'ModuleFaqListTagstsTags';
}

/**
 * Content elements
	*/
$GLOBALS['TL_CTE']['texts']['headline'] = 'ContentHeadlineTags';
$GLOBALS['TL_CTE']['media']['gallery'] = 'ContentGalleryTags';
	
if (TL_MODE == 'BE')
{
	/**
	 * CSS files
	 */

	if (is_array($GLOBALS['TL_CSS']))
	{
		array_insert($GLOBALS['TL_CSS'], 1, 'system/modules/tags/assets/tag.css');
	}
	else
	{
		$GLOBALS['TL_CSS'] = array('system/modules/tags/assets/tag.css');
	}

	/**
	 * JavaScript files
	 */
	if (is_array($GLOBALS['TL_JAVASCRIPT']))
	{
		array_insert($GLOBALS['TL_JAVASCRIPT'], 1, 'system/modules/tags/assets/tag.js');
	}
	else
	{
		$GLOBALS['TL_JAVASCRIPT'] = array('system/modules/tags/assets/tag.js');
	}
}

/**
 * Hooks
 */
$GLOBALS['TL_HOOKS']['reviseTable'][] = array('TagHelper', 'deleteIncompleteRecords');
$GLOBALS['TL_HOOKS']['reviseTable'][] = array('TagHelper', 'deleteUnusedTagsForTable');
$GLOBALS['TL_HOOKS']['replaceInsertTags'][] = array('TagHelper', 'replaceTagInsertTags');
$GLOBALS['TL_HOOKS']['parseArticles'][] = array('TagHelper', 'parseArticlesHook');

/**
* source tables that have tags enabled
*/
$GLOBALS['tags_extension']['sourcetable'][] = 'tl_article';
$GLOBALS['tags_extension']['sourcetable'][] = 'tl_calendar_events';
$GLOBALS['tags_extension']['sourcetable'][] = 'tl_content';
$GLOBALS['tags_extension']['sourcetable'][] = 'tl_news';

/**
* Add 'tag' to the URL keywords to prevent problems with URL manipulating modules like folderurl
*/
$GLOBALS['TL_CONFIG']['urlKeywords'] .= (strlen(trim($GLOBALS['TL_CONFIG']['urlKeywords'])) ? ',' : '') . 'tag';
$GLOBALS['tags']['showInFeeds'] = true;


if (is_array($GLOBALS['TL_CRON']['daily']))
{
	foreach ($GLOBALS['TL_CRON']['daily'] as $key => $arr)
	{
		if (is_array($arr) && strcmp($arr[0], 'Calendar') == 0 && strcmp($arr[1], 'generateFeeds') == 0)
		{
			// Fix calendar feed cron job
			$GLOBALS['TL_CRON']['daily'][$key] = array('CalendarTags', 'generateFeeds');
		}
		if (is_array($arr) && strcmp($arr[0], 'News') == 0 && strcmp($arr[1], 'generateFeeds') == 0)
		{
			// Fix news feed cron job
			$GLOBALS['TL_CRON']['daily'][$key] = array('NewsTags', 'generateFeeds');
		}
	}
}

