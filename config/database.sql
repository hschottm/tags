-- **********************************************************
-- *                                                        *
-- * IMPORTANT NOTE                                         *
-- *                                                        *
-- * Do not import this file manually but use the TYPOlight *
-- * install tool to create and maintain database tables!   *
-- *                                                        *
-- **********************************************************

-- 
-- Table `tl_tag`
-- 

CREATE TABLE `tl_tag` (
  `id` int(10) unsigned NOT NULL default '0',
  `tag` varchar(100) NOT NULL default '',
  `from_table` varchar(100) NOT NULL default '',
  KEY `id` (`id`),
  KEY `tag` (`tag`),
  KEY `from_table` (`from_table`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Table `tl_module`
-- 

CREATE TABLE `tl_module` (
  `tag_jumpTo` smallint(5) unsigned NOT NULL default '0',
  `tag_sourcetables` blob NULL,
  `tag_tagtable` varchar(100) NOT NULL default '',
  `tag_tagfield` varchar(100) NOT NULL default '',
  `tag_maxtags` smallint(5) unsigned NOT NULL default '0',
  `tag_buckets` smallint(5) unsigned NOT NULL default '4',
  `tag_topten` char(1) NOT NULL default '',
  `tag_topten_expanded` char(1) NOT NULL default '',
  `tag_all_expanded` char(1) NOT NULL default '',
  `tag_named_class` char(1) NOT NULL default '',
  `tag_on_page_class` char(1) NOT NULL default '',
  `tag_related` char(1) NOT NULL default '',
  `news_showtags` char(1) NOT NULL default '',
  `tag_filter` varchar(255) NOT NULL default '',
  `tag_ignore` char(1) NOT NULL default '',
  `keep_url_params` char(1) NOT NULL default '',
  `show_empty_scope` char(1) NOT NULL default '',
  `tag_show_reset` char(1) NOT NULL default '',
  `hide_on_empty` char(1) NOT NULL default '1',
  `objecttype` varchar(100) NOT NULL default '',
  `tagsource` varchar(100) NOT NULL default '',
  `articlelist_template` varchar(32) NOT NULL default '',
  `cloud_template` varchar(32) NOT NULL default '',
  `scope_template` varchar(32) NOT NULL default '',
  `clear_text` varchar(128) NOT NULL default '',
  `pagesource` blob NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Table `tl_article`
-- 

CREATE TABLE `tl_article` (
	`tags` char(1) NOT NULL default ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Table `tl_news`
-- 

CREATE TABLE `tl_news` (
	`tags` char(1) NOT NULL default ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Table `tl_calendar_events`
-- 

CREATE TABLE `tl_calendar_events` (
	`tags` char(1) NOT NULL default ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Table `tl_content`
-- 

CREATE TABLE `tl_content` (
  `tags` char(1) NOT NULL default '',
  `tagsonly` char(1) NOT NULL default ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
