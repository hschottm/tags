<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2015 Leo Feyer
 *
 * @license LGPL-3.0+
 */

namespace Contao;


/**
 * Front end module "calendar".
 *
 * @author Leo Feyer <https://github.com/leofeyer>
 */
class ModuleCalendarTags extends \ModuleCalendar
{

	/**
	 * Return all weeks of the current month as array
	 *
	 * @return array
	 */
	protected function compileWeeks()
	{
		$arrDays = parent::compileWeeks();
		$helper = new \TagHelper();
		foreach ($arrDays as $strWeekClass => $week)
		{
			foreach ($week as $i => $event)
			{
				foreach ($event['events'] as $eventindex => $vv)
				{
					$tagsandlist = $helper->getTagsAndTaglistForIdAndTable($vv['id'], 'tl_calendar_events', $this->jumpTo);
					$vv['tags'] = $tagsandlist['tags'];
					$vv['taglist'] = $tagsandlist['taglist'];
					$arrDays[$strWeekClass][$i]['events'][$eventindex] = $vv;
				}
			}
		}
		return $arrDays;
	}
}