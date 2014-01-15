<?php

/**
 * @package Calendar
 * @copyright  Helmut Schottmüller 2009-2013
 * @author     Helmut Schottmüller <https://github.com/hschottm>
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace Contao;


/**
 * Class ModuleEventReaderTags
 *
 * Front end module "event reader".
 * @copyright  Helmut Schottmüller 2009-2013
 * @author     Helmut Schottmüller <https://github.com/hschottm>
 * @package    Calendar
 */
class ModuleEventReaderTags extends \ModuleEventReader
{

	/**
	 * Generate the module
	 */
	protected function compile()
	{
		global $objPage;

		$this->Template->event = '';
		$this->Template->referer = 'javascript:history.go(-1)';
		$this->Template->back = $GLOBALS['TL_LANG']['MSC']['goBack'];

		// Get the current event
		$objEvent = \CalendarEventsModel::findPublishedByParentAndIdOrAlias(\Input::get('events'), $this->cal_calendar);

		if ($objEvent === null)
		{
			// Do not index or cache the page
			$objPage->noSearch = 1;
			$objPage->cache = 0;

			// Send a 404 header
			header('HTTP/1.1 404 Not Found');
			$this->Template->event = '<p class="error">' . sprintf($GLOBALS['TL_LANG']['MSC']['invalidPage'], \Input::get('events')) . '</p>';
			return;
		}

		// Overwrite the page title (see #2853 and #4955)
		if ($objEvent->title != '')
		{
			$objPage->pageTitle = strip_tags(strip_insert_tags($objEvent->title));
		}

		// Overwrite the page description
		if ($objEvent->teaser != '')
		{
			$objPage->description = $this->prepareMetaDescription($objEvent->teaser);
		}

		$intStartTime = $objEvent->startTime;
		$intEndTime = $objEvent->endTime;
		$span = \Calendar::calculateSpan($intStartTime, $intEndTime);

		// Do not show dates in the past if the event is recurring (see #923)
		if ($objEvent->recurring)
		{
			$arrRange = deserialize($objEvent->repeatEach);

			while ($intStartTime < time() && $intEndTime < $objEvent->repeatEnd)
			{
				$intStartTime = strtotime('+' . $arrRange['value'] . ' ' . $arrRange['unit'], $intStartTime);
				$intEndTime = strtotime('+' . $arrRange['value'] . ' ' . $arrRange['unit'], $intEndTime);
			}
		}

		if ($objPage->outputFormat == 'xhtml')
		{
			$strTimeStart = '';
			$strTimeEnd = '';
			$strTimeClose = '';
		}
		else
		{
			$strTimeStart = '<time datetime="' . date('Y-m-d\TH:i:sP', $intStartTime) . '">';
			$strTimeEnd = '<time datetime="' . date('Y-m-d\TH:i:sP', $intEndTime) . '">';
			$strTimeClose = '</time>';
		}

		// Get date
		if ($span > 0)
		{
			$date = $strTimeStart . \Date::parse(($objEvent->addTime ? $objPage->datimFormat : $objPage->dateFormat), $intStartTime) . $strTimeClose . ' - ' . $strTimeEnd . \Date::parse(($objEvent->addTime ? $objPage->datimFormat : $objPage->dateFormat), $intEndTime) . $strTimeClose;
		}
		elseif ($intStartTime == $intEndTime)
		{
			$date = $strTimeStart . \Date::parse($objPage->dateFormat, $intStartTime) . ($objEvent->addTime ? ' (' . \Date::parse($objPage->timeFormat, $intStartTime) . ')' : '') . $strTimeClose;
		}
		else
		{
			$date = $strTimeStart . \Date::parse($objPage->dateFormat, $intStartTime) . ($objEvent->addTime ? ' (' . \Date::parse($objPage->timeFormat, $intStartTime) . $strTimeClose . ' - ' . $strTimeEnd . \Date::parse($objPage->timeFormat, $intEndTime) . ')' : '') . $strTimeClose;
		}

		$until = '';
		$recurring = '';

		// Recurring event
		if ($objEvent->recurring)
		{
			$arrRange = deserialize($objEvent->repeatEach);
			$strKey = 'cal_' . $arrRange['unit'];
			$recurring = sprintf($GLOBALS['TL_LANG']['MSC'][$strKey], $arrRange['value']);

			if ($objEvent->recurrences > 0)
			{
				$until = sprintf($GLOBALS['TL_LANG']['MSC']['cal_until'], \Date::parse($objPage->dateFormat, $objEvent->repeatEnd));
			}
		}

		// Override the default image size
		if ($this->imgSize != '')
		{
			$size = deserialize($this->imgSize);

			if ($size[0] > 0 || $size[1] > 0)
			{
				$objEvent->size = $this->imgSize;
			}
		}

		$objTemplate = new \FrontendTemplate($this->cal_template);
		$objTemplate->setData($objEvent->row());

		$objTemplate->date = $date;
		$objTemplate->start = $intStartTime;
		$objTemplate->end = $intEndTime;
		$objTemplate->class = ($objEvent->cssClass != '') ? ' ' . $objEvent->cssClass : '';
		$objTemplate->recurring = $recurring;
		$objTemplate->until = $until;
		$objTemplate->locationLabel = $GLOBALS['TL_LANG']['MSC']['location'];

		$objTemplate->details = '';
		$objElement = \ContentModel::findPublishedByPidAndTable($objEvent->id, 'tl_calendar_events');

		if ($objElement !== null)
		{
			while ($objElement->next())
			{
				$objTemplate->details .= $this->getContentElement($objElement->id);
			}
		}

		$objTemplate->addImage = false;

		// Add an image
		if ($objEvent->addImage && $objEvent->singleSRC != '')
		{
			$objModel = \FilesModel::findByUuid($objEvent->singleSRC);

			if ($objModel === null)
			{
				if (!\Validator::isUuid($objEvent->singleSRC))
				{
					$objTemplate->text = '<p class="error">'.$GLOBALS['TL_LANG']['ERR']['version2format'].'</p>';
				}
			}
			elseif (is_file(TL_ROOT . '/' . $objModel->path))
			{
				// Do not override the field now that we have a model registry (see #6303)
				$arrEvent = $objEvent->row();
				$arrEvent['singleSRC'] = $objModel->path;

				$this->addImageToTemplate($objTemplate, $arrEvent);
			}
		}

		$objTemplate->enclosure = array();

		// Add enclosures
		if ($objEvent->addEnclosure)
		{
			$this->addEnclosuresToTemplate($objTemplate, $objEvent->row());
		}

		////////// CHANGES BY ModuleEventlistTags
		$objTemplate->showTags = $this->event_showtags;
		if ($this->event_showtags)
		{
			$helper = new TagHelper();
			$tagsandlist = $helper->getTagsAndTaglistForIdAndTable($objEvent->id, 'tl_calendar_events', $this->tag_jumpTo);
			$tags = $tagsandlist['tags'];
			$taglist = $tagsandlist['taglist'];
			$objTemplate->showTagClass = $this->tag_named_class;
			$objTemplate->tags = $tags;
			$objTemplate->taglist = $taglist;
		}
		////////// CHANGES BY ModuleEventlistTags

		$this->Template->event = $objTemplate->parse();

		// HOOK: comments extension required
		if ($objEvent->noComments || !in_array('comments', \ModuleLoader::getActive()))
		{
			$this->Template->allowComments = false;
			return;
		}

		$objCalendar = $objEvent->getRelated('pid');
		$this->Template->allowComments = $objCalendar->allowComments;

		// Comments are not allowed
		if (!$objCalendar->allowComments)
		{
			return;
		}

		// Adjust the comments headline level
		$intHl = min(intval(str_replace('h', '', $this->hl)), 5);
		$this->Template->hlc = 'h' . ($intHl + 1);

		$this->import('Comments');
		$arrNotifies = array();

		// Notify the system administrator
		if ($objCalendar->notify != 'notify_author')
		{
			$arrNotifies[] = $GLOBALS['TL_ADMIN_EMAIL'];
		}

		// Notify the author
		if ($objCalendar->notify != 'notify_admin')
		{
			if (($objAuthor = $objEvent->getRelated('author')) !== null && $objAuthor->email != '')
			{
				$arrNotifies[] = $objAuthor->email;
			}
		}

		$objConfig = new \stdClass();

		$objConfig->perPage = $objCalendar->perPage;
		$objConfig->order = $objCalendar->sortOrder;
		$objConfig->template = $this->com_template;
		$objConfig->requireLogin = $objCalendar->requireLogin;
		$objConfig->disableCaptcha = $objCalendar->disableCaptcha;
		$objConfig->bbcode = $objCalendar->bbcode;
		$objConfig->moderate = $objCalendar->moderate;

		$this->Comments->addCommentsToTemplate($this->Template, $objConfig, 'tl_calendar_events', $objEvent->id, $arrNotifies);
	}
}
