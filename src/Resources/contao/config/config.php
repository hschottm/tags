<?php

declare(strict_types=1);

use Contao\System;
use Symfony\Component\HttpFoundation\Request;
use Hschottm\TagsBundle\TagField;
use Hschottm\TagsBundle\TagHelper;
use Hschottm\TagsBundle\TagMemberHelper;

/**
 * Contao Open Source CMS - tags extension
 *
 * Copyright (c) 2008-2024 Helmut Schottmüller
 *
 * @license LGPL-3.0+
 */

/**
 * Back end widgets
 */
$GLOBALS['BE_FFL']['tag'] = TagField::class;

/**
 * Front end widgets
 */
$GLOBALS['TL_FFL']['tag'] = Hschottm\TagsBundle\TagFieldMemberFrontend::class;

/**
 * Front end modules
 */
\Contao\ArrayUtil::arrayInsert($GLOBALS['FE_MOD']['tags'], 1, array
(
	'tagcloud'            => Hschottm\TagsBundle\ModuleTagCloud::class,
	'tagcloudarticles'    => Hschottm\TagsBundle\ModuleTagCloudArticles::class,
	'taggedArticleList'   => Hschottm\TagsBundle\ModuleTaggedArticleList::class,
  	'tagscope'            => Hschottm\TagsBundle\ModuleTagScope::class,
	'tagcontentlist'      => Hschottm\TagsBundle\ModuleTagContentList::class,
	'taglistbycategory'   => Hschottm\TagsBundle\ModuleTagListByCategory::class,
	'tagcloudcontent'     => Hschottm\TagsBundle\ModuleTagCloudContent::class,
	'tagcloudevents'      => Hschottm\TagsBundle\ModuleTagCloudEvents::class,
	'tagcloudmembers'     => Hschottm\TagsBundle\ModuleTagCloudMembers::class,
	'tagcloudnews'        => Hschottm\TagsBundle\ModuleTagCloudNews::class
));
\Contao\ArrayUtil::arrayInsert($GLOBALS['FE_MOD']['miscellaneous'], 3, array
(
	'globalArticleList'    => Hschottm\TagsBundle\ModuleGlobalArticlelist::class
));

$GLOBALS['FE_MOD']['news']['newslist'] = Hschottm\TagsBundle\ModuleNewsListTags::class;
$GLOBALS['FE_MOD']['news']['newsarchive'] = Hschottm\TagsBundle\ModuleNewsArchiveTags::class;
$GLOBALS['FE_MOD']['news']['newsreader'] = Hschottm\TagsBundle\ModuleNewsReaderTags::class;
$GLOBALS['FE_MOD']['events']['calendar'] = Hschottm\TagsBundle\ModuleCalendarTags::class;
$GLOBALS['FE_MOD']['events']['eventlist'] = Hschottm\TagsBundle\ModuleEventlistTags::class;
$GLOBALS['FE_MOD']['events']['eventreader'] = Hschottm\TagsBundle\ModuleEventReaderTags::class;
$GLOBALS['FE_MOD']['faq']['faqlist'] = Hschottm\TagsBundle\ModuleFaqListTags::class;

if (array_key_exists('last_events', $GLOBALS['FE_MOD']['events']))
{
	// add support for last_events extension
	$GLOBALS['FE_MOD']['events']['last_events'] = Hschottm\TagsBundle\ModuleFaqListTags::class;
}

$GLOBALS['TL_MODELS']['tl_tag'] = Hschottm\TagsBundle\TagModel::class;

/**
 * Content elements
	*/
$GLOBALS['TL_CTE']['texts']['headline'] = Hschottm\TagsBundle\ContentHeadlineTags::class;
$GLOBALS['TL_CTE']['media']['gallery'] = Hschottm\TagsBundle\ContentGalleryTags::class;

// previously css and js have been added only to the backend
/*
if (System::getContainer()->get('contao.routing.scope_matcher')
    ->isBackendRequest(System::getContainer()->get('request_stack')->getCurrentRequest() ?? Request::create(''))
) 
{
}
*/

/**
 * CSS files
 */

$GLOBALS['TL_CSS'][] = 'bundles/hschottmtags/css/tag.css';

/**
 * JavaScript files
 */
$GLOBALS['TL_JAVASCRIPT'][] = 'bundles/hschottmtags/js/tag.js';
 
/**
 * Hooks
 */

//$GLOBALS['TL_HOOKS']['reviseTable'][] = array(Hschottm\TagsBundle\TagHelper::class, 'deleteIncompleteRecords'); -> see ReviseTableListener
//$GLOBALS['TL_HOOKS']['reviseTable'][] = array(Hschottm\TagsBundle\TagHelper::class, 'deleteUnusedTagsForTable'); -> see ReviseTableListener
//$GLOBALS['TL_HOOKS']['replaceInsertTags'][] = array(Hschottm\TagsBundle\TagHelper::class, 'replaceTagInsertTags'); -> see InsertTag namespace
//$GLOBALS['TL_HOOKS']['parseArticles'][] = array(Hschottm\TagsBundle\TagHelper::class, 'parseArticlesHook'); -> see ParseArticlesListener
//$GLOBALS['TL_HOOKS']['compileArticle'][] = array(Hschottm\TagsBundle\TagHelper::class, 'compileArticleHook'); -> see CompileArticleListener
// for contao-memberlist
//$GLOBALS['TL_HOOKS']['setMemberlistOptions'][] = array(Hschottm\TagsBundle\TagMemberHelper::class, 'setMemberlistOptions'); -> TBD, extension is no longer working with Contao 5


/**
* source tables that have tags enabled
*/
$GLOBALS['tags_extension']['sourcetable'][] = 'tl_article';
$GLOBALS['tags_extension']['sourcetable'][] = 'tl_calendar_events';
$GLOBALS['tags_extension']['sourcetable'][] = 'tl_content';
$GLOBALS['tags_extension']['sourcetable'][] = 'tl_news';
$GLOBALS['tags_extension']['sourcetable'][] = 'tl_member';
$GLOBALS['tags_extension']['sourcetable'][] = 'tl_faq';
$GLOBALS['tags_extension']['sourcetable'][] = 'fl_files';

/**
* Add 'tag' to the URL keywords to prevent problems with URL manipulating modules like folderurl
*/
if (isset($GLOBALS['TL_CONFIG']['urlKeywords'])) {
	$GLOBALS['TL_CONFIG']['urlKeywords'] .= (strlen(trim($GLOBALS['TL_CONFIG']['urlKeywords'])) ? ',' : '') . 'tag';
} else {
	$GLOBALS['TL_CONFIG']['urlKeywords'] = 'tag';
}
$GLOBALS['tags']['showInFeeds'] = true;

