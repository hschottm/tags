<?php

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

