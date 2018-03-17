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
 * @copyright  Helmut Schottmüller 2008-2010
 * @author     Helmut Schottmüller <contao@aurealis.de>
 * @package    tags
 * @license    LGPL
 * @filesource
 */


/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_module']['tag_jumpTo']          = array('Jump to page', 'This setting defines to which page a user will be redirected on clicking a tag link.');
$GLOBALS['TL_LANG']['tl_module']['tag_forTable']        = array('Tag tables', 'Please select the tables which are used to show the tag cloud. This selection is valid only if you use the predefined <em>tl_tag</em> table to store the tags.');
$GLOBALS['TL_LANG']['tl_module']['tag_tagtable']        = array('Tag source table', 'Please enter the name of the source table in which the tags can be found. This field defaults to the predefined table <em>tl_tag</em>.');
$GLOBALS['TL_LANG']['tl_module']['tag_tagfield']        = array('Tag table field', 'Please enter the name of the table field which holds the tags. This field defaults to the predefined field name <em>tag</em>.');
$GLOBALS['TL_LANG']['tl_module']['tag_filter']          = array('Tag filter', 'Please enter a comma separated list of tags to filter the output of the module.');
$GLOBALS['TL_LANG']['tl_module']['tag_maxtags']         = array('Maximum number of tags', 'Please enter the maximum number of tags in the tag cloud. If the tag cloud contains more tags than the maximum number of tags, the tags with the smallest number hits will be removed from the cloud. If you don\'t enter a value or the value is 0, all tags will be shown.');
$GLOBALS['TL_LANG']['tl_module']['tag_buckets']         = array('Number of tag sizes', 'Please enter the number of tag sizes in the frontend. Every group of tags gets its own tag size in the frontend. The tag sizes will be give as CSS selectors size1, size2, size3 ... size<em>n</em>.');
$GLOBALS['TL_LANG']['tl_module']['tag_named_class']     = array('Use tag classname', 'Adds an additional CSS class class for every tag which contains the tag name. Use this extra class name for additional styling of tags via CSS. Spaces in the tag names will be replaced with underscores in the CSS class names.');
$GLOBALS['TL_LANG']['tl_module']['tag_on_page_class']   = array('Tag exists on page', 'Adds an additional CSS class (\'here\') for every tag that has been assigned to the actual page.');
$GLOBALS['TL_LANG']['tl_module']['tag_topten']          = array('Top Tags', 'Show the Top Tags above the tag cloud.');
$GLOBALS['TL_LANG']['tl_module']['tag_topten_expanded'] = array('Expand Top Tags', 'Expand the Top Tags tag cloud. All tags in this cloud are visible.');
$GLOBALS['TL_LANG']['tl_module']['tag_topten_number']   = array('Number of Top Tags', 'Enter the maximum number that should be used for the Top Tags.');
$GLOBALS['TL_LANG']['tl_module']['tag_all_expanded']    = array('Expand All Tags', 'Expand the \'All Tags\' tag cloud. All tags in this cloud are visible.');
$GLOBALS['TL_LANG']['tl_module']['tag_related']         = array('Show related tags', 'Select this option to show all related tags of a previously selected tag.');
$GLOBALS['TL_LANG']['tl_module']['news_showtags']       = array('Show news tags', 'Select this option to show all assigned tags below each news entry. This only works if you use a tag enabled news template, e.g. news_full_tags');
$GLOBALS['TL_LANG']['tl_module']['event_showtags']       = array('Show event tags', 'Select this option to show all assigned tags below each event. This only works if you use a tag enabled event template, e.g. event_..._tags');
$GLOBALS['TL_LANG']['tl_module']['tag_ignore']          = array('Ignore tags', 'Force this module to ignore tag related actions (e.g. only show news entries of a given tag)');
$GLOBALS['TL_LANG']['tl_module']['keep_url_params']     = array('Keep URL parameters', 'Keep Contao specific URL parameters (e.g. date parameters of news archives) in the tag links');
$GLOBALS['TL_LANG']['tl_module']['objecttype']          = array('Object type', 'Please select the type of object that should be shown in this list.');
$GLOBALS['TL_LANG']['tl_module']['tagsource']           = array('Tag source', 'Please select the table which is used to build the tag list in this module.');
$GLOBALS['TL_LANG']['tl_module']['pagesource']          = array('Pages', 'Please select the pages that are used to build the object list. If you select a page which contains subpages, all subpages will be used too.');
$GLOBALS['TL_LANG']['tl_module']['articlelist_template'] = array('Articlelist template', 'Here you can select the articlelist template.');
$GLOBALS['TL_LANG']['tl_module']['cloud_template']      = array('Tag cloud template', 'Here you can select the tag cloud template.');
$GLOBALS['TL_LANG']['tl_module']['scope_template']      = array('Tag scope template', 'Here you can select the tag scope template.');
$GLOBALS['TL_LANG']['tl_module']['clear_text']          = array('Tag scope title', 'Please enter a title for the tag scope. The title is a hyperlink that clears the tag scope and removes all selected tags.');
$GLOBALS['TL_LANG']['tl_module']['show_empty_scope']    = array('Show empty scope', 'Show the tag scope even if there are no active tags.');
$GLOBALS['TL_LANG']['tl_module']['tag_show_reset']      = array('Show clear option', 'Show a hyperlink to clear all selected tags.');
$GLOBALS['TL_LANG']['tl_module']['hide_on_empty']       = array('Filtered output only', 'The global articlelist always expects one or more tags to produce a filtered output. Without a tag filter, an empty list is shown.');
$GLOBALS['TL_LANG']['tl_module']['tag_alltags']         = 'All Tags';
$GLOBALS['TL_LANG']['tl_module']['tag_relatedtags']     = 'Related Tags';
$GLOBALS['TL_LANG']['tl_module']['tl_content']          = "Content elements";
$GLOBALS['TL_LANG']['tl_module']['tl_article']          = "Articles";
$GLOBALS['TL_LANG']['tl_module']['tl_news']             = "News articles";
$GLOBALS['TL_LANG']['tl_module']['tag_clear_tags']      = "Clear selected tags";
$GLOBALS['TL_LANG']['tl_module']['tl_calendar_events']  = "Events";
$GLOBALS['TL_LANG']['tl_module']['tl_page']             = "Pages";
$GLOBALS['TL_LANG']['tl_module']['tags']                = "Tags";
$GLOBALS['TL_LANG']['tl_module']['top_tags']            = 'Top %s Tags';

/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_module']['showtags_legend']         = 'Tags settings';
$GLOBALS['TL_LANG']['tl_module']['tagscope_legend']         = 'Tag scope settings';
$GLOBALS['TL_LANG']['tl_module']['size_legend']         = 'Number and size settings';
$GLOBALS['TL_LANG']['tl_module']['tagextension_legend'] = 'Additional tag lists';
$GLOBALS['TL_LANG']['tl_module']['datasource_legend'] = 'Datasource settings';
$GLOBALS['TL_LANG']['tl_module']['object_selection_legend'] = "Object types";

// articles

$GLOBALS['TL_LANG']['tl_module']['tag_articles']   = array('Articles', 'Please select the pages theirs articles are used to build the tag cloud. If you check a page which contains subpages, the articles of all subpages will be used too.');
$GLOBALS['TL_LANG']['tl_module']['show_in_column'] = array('Restrict to specific column', 'Restrict the output of the article list to a specific column of the page template.');
$GLOBALS['TL_LANG']['tl_module']['linktoarticles'] = array('Article list links to articles', 'Check to create an article list with links to the article or uncheck to create an article list with links to the containing page.');
$GLOBALS['TL_LANG']['tl_module']['restrict_to_column'] = array('Restrict to specific column', 'Restrict the tag cloud to tags of articles from a specific column of the page template.');
$GLOBALS['TL_LANG']['tl_module']['articlelist_tpl'] = array('Article list template', 'Here you can select the article list template.');
$GLOBALS['TL_LANG']['tl_module']['article_showtags']       = array('Show article tags', 'Select this option to show all assigned tags below each article. This only works if you use a tag enabled article template, e.g. mod_global_articlelist');
$GLOBALS['TL_LANG']['tl_module']['articlelist_firstorder'] = array('First sort criteria', 'Select the first sort criteria for the resulting article list.');
$GLOBALS['TL_LANG']['tl_module']['articlelist_secondorder'] = array('Second sort criteria', 'Select the second sort criteria for the resulting article list.');

// content

$GLOBALS['TL_LANG']['tl_module']['tag_content_pages']   = array('Pages', 'Please select the pages theirs content elements are used to build the tag cloud. If you select a page which contains subpages, the content elements of all subpages will be used too.');

// events

$GLOBALS['TL_LANG']['tl_module']['tag_calendars']   = array('Calendars', 'Please select the calendars which are used to build the tag cloud.');

// members

$GLOBALS['TL_LANG']['tl_module']['tag_membergroups']   = array('Member groups', 'Please select one or more member groups to build the member tag cloud.');

// news

$GLOBALS['TL_LANG']['tl_module']['tag_news_archives']   = array('News archives', 'Please select the news archives which are used to build the tag cloud.');

?>
