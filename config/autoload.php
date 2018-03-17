<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2016 Leo Feyer
 *
 * @license LGPL-3.0+
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'Aurealis',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Classes
	'Contao\CalendarTags'            => 'system/modules/tags/classes/CalendarTags.php',
	'Contao\ContentHeadlineTags'     => 'system/modules/tags/classes/ContentHeadlineTags.php',
	'Contao\NewsTags'                => 'system/modules/tags/classes/NewsTags.php',
	'Contao\TagField'                => 'system/modules/tags/classes/TagField.php',
	'Contao\TagHelper'               => 'system/modules/tags/classes/TagHelper.php',
	'Contao\TagList'                 => 'system/modules/tags/classes/TagList.php',
  'Contao\TagListArticles'         => 'system/modules/tags/classes/TagListArticles.php',
  'Contao\TagListContentElements'  => 'system/modules/tags/classes/TagListContentElements.php',
  'Contao\TagListEvents'           => 'system/modules/tags/classes/TagListEvents.php',
  'Contao\TagFieldMemberFrontend'  => 'system/modules/tags/classes/TagFieldMemberFrontend.php',
	'Contao\TagListMembers'          => 'system/modules/tags/classes/TagListMembers.php',
	'Contao\TagMemberHelper'         => 'system/modules/tags/classes/TagMemberHelper.php',
  'Contao\TagListNews'             => 'system/modules/tags/classes/TagListNews.php',

	// Elements
	'Contao\ContentGalleryTags'      => 'system/modules/tags/elements/ContentGalleryTags.php',

	// Models
	'Contao\TagModel'                => 'system/modules/tags/models/TagModel.php',
	'Contao\TagsFaqModel'            => 'system/modules/tags/models/TagsFaqModel.php',
	'Contao\TagsNewsModel'           => 'system/modules/tags/models/TagsNewsModel.php',

	// Modules
	'Aurealis\ModuleArticle'         => 'system/modules/tags/modules/ModuleArticle.php',
	'Contao\ModuleCalendarTags'      => 'system/modules/tags/modules/ModuleCalendarTags.php',
	'Contao\ModuleEventlistTags'     => 'system/modules/tags/modules/ModuleEventlistTags.php',
	'Contao\ModuleEventReaderTags'   => 'system/modules/tags/modules/ModuleEventReaderTags.php',
	'Contao\ModuleFaqListTags'       => 'system/modules/tags/modules/ModuleFaqListTags.php',
	'Contao\ModuleGlobalArticlelist' => 'system/modules/tags/modules/ModuleGlobalArticlelist.php',
	'Contao\ModuleLastEventsTags'    => 'system/modules/tags/modules/ModuleLastEventsTags.php',
	'Contao\ModuleNewsArchiveTags'   => 'system/modules/tags/modules/ModuleNewsArchiveTags.php',
	'Contao\ModuleNewsListTags'      => 'system/modules/tags/modules/ModuleNewsListTags.php',
	'Contao\ModuleNewsReaderTags'    => 'system/modules/tags/modules/ModuleNewsReaderTags.php',
	'Contao\ModuleTagCloud'          => 'system/modules/tags/modules/ModuleTagCloud.php',
  'Contao\ModuleTagCloudArticles'  => 'system/modules/tags/modules/ModuleTagCloudArticles.php',
	'Contao\ModuleTaggedArticleList' => 'system/modules/tags/modules/ModuleTaggedArticleList.php',
	'Contao\ModuleTagContentList'    => 'system/modules/tags/modules/ModuleTagContentList.php',
	'Contao\ModuleTagListByCategory' => 'system/modules/tags/modules/ModuleTagListByCategory.php',
	'Contao\ModuleTagScope'          => 'system/modules/tags/modules/ModuleTagScope.php',
  'Contao\ModuleTagCloudContent'   => 'system/modules/tags/modules/ModuleTagCloudContent.php',
  'Contao\ModuleTagCloudEvents'    => 'system/modules/tags/modules/ModuleTagCloudEvents.php',
  'Contao\ModuleTagCloudMembers'   => 'system/modules/tags/modules/ModuleTagCloudMembers.php',
  'Contao\ModuleTagCloudNews'      => 'system/modules/tags/modules/ModuleTagCloudNews.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'event_default_tags'     => 'system/modules/tags/templates/events',
	'event_full_tags'        => 'system/modules/tags/templates/events',
	'event_list_tags'        => 'system/modules/tags/templates/events',
	'mod_article_tags'       => 'system/modules/tags/templates/modules',
	'mod_global_articlelist' => 'system/modules/tags/templates/modules',
	'mod_tag_contentlist'    => 'system/modules/tags/templates/modules',
	'mod_tag_listbycategory' => 'system/modules/tags/templates/modules',
	'mod_tagcloud'           => 'system/modules/tags/templates/modules',
	'mod_tagscope'           => 'system/modules/tags/templates/modules',
	'news_full_tags'         => 'system/modules/tags/templates/news',
	'taglist'                => 'system/modules/tags/templates/tags',
	'tags_feed'              => 'system/modules/tags/templates/tags',
	'tags_inserttag'         => 'system/modules/tags/templates/tags',
	'tags_used'              => 'system/modules/tags/templates/tags',
));
