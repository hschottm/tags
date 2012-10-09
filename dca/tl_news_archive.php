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


if (@class_exists("tl_news_archive"))
{

if (is_array($GLOBALS['TL_DCA']['tl_news_archive']['config']['onload_callback']))
{
	foreach ($GLOBALS['TL_DCA']['tl_news_archive']['config']['onload_callback'] as $key => $arr)
	{
		if (is_array($arr) && strcmp($arr[0], 'tl_news_archive') == 0 && strcmp($arr[1], 'generateFeed') == 0)
		{
			$GLOBALS['TL_DCA']['tl_news_archive']['config']['onload_callback'][$key] = array('TagHelper', 'generateNewsFeed');
		}
	}
}

}

?>