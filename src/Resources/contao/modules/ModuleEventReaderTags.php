<?php

namespace Hschottm\TagsBundle;

use Contao\ModuleEventReader;
use Contao\CoreBundle\Exception\InternalServerErrorException;
use Contao\CoreBundle\Exception\PageNotFoundException;
use Contao\CoreBundle\Exception\RedirectResponseException;
use Contao\CoreBundle\Routing\ResponseContext\HtmlHeadBag\HtmlHeadBag;
use Contao\Comments;
use Contao\FrontendTemplate;

/**
 * Contao Open Source CMS - tags extension
 *
 * Copyright (c) 2008-2024 Helmut Schottmüller
 *
 * @license LGPL-3.0+
 */

class ModuleEventReaderTags extends ModuleEventReader
{
	/**
	 * Return the date and time strings
	 *
	 * @param CalendarEventsModel $objEvent
	 * @param PageModel           $objPage
	 * @param integer             $intStartTime
	 * @param integer             $intEndTime
	 * @param integer             $span
	 *
	 * @return array
	 */
	private function getDateAndTime(CalendarEventsModel $objEvent, PageModel $objPage, $intStartTime, $intEndTime, $span)
	{
		$strDate = Date::parse($objPage->dateFormat, $intStartTime);

		if ($span > 0)
		{
			$strDate = Date::parse($objPage->dateFormat, $intStartTime) . $GLOBALS['TL_LANG']['MSC']['cal_timeSeparator'] . Date::parse($objPage->dateFormat, $intEndTime);
		}

		$strTime = '';

		if ($objEvent->addTime)
		{
			if ($span > 0)
			{
				$strDate = Date::parse($objPage->datimFormat, $intStartTime) . $GLOBALS['TL_LANG']['MSC']['cal_timeSeparator'] . Date::parse($objPage->datimFormat, $intEndTime);
			}
			elseif ($intStartTime == $intEndTime)
			{
				$strTime = Date::parse($objPage->timeFormat, $intStartTime);
			}
			else
			{
				$strTime = Date::parse($objPage->timeFormat, $intStartTime) . $GLOBALS['TL_LANG']['MSC']['cal_timeSeparator'] . Date::parse($objPage->timeFormat, $intEndTime);
			}
		}

		return array($strDate, $strTime);
	}
	
	/**
	 * Generate the module
	 */
	protected function compile()
	{
		global $objPage;

		$this->Template->event = '';

		$urlGenerator = System::getContainer()->get('contao.routing.content_url_generator');

		if ($this->overviewPage && ($overviewPage = PageModel::findById($this->overviewPage)))
		{
			$this->Template->referer = $urlGenerator->generate($overviewPage);
			$this->Template->back = $this->customLabel ?: $GLOBALS['TL_LANG']['MSC']['eventOverview'];
		}

		// Get the current event
		$objEvent = CalendarEventsModel::findPublishedByParentAndIdOrAlias(Input::get('auto_item'), $this->cal_calendar);

		// The event does not exist (see #33)
		if ($objEvent === null)
		{
			throw new PageNotFoundException('Page not found: ' . Environment::get('uri'));
		}

		// Redirect if the event has a target URL (see #1498)
		switch ($objEvent->source)
		{
			case 'internal':
			case 'article':
			case 'external':
				throw new RedirectResponseException($urlGenerator->generate($objEvent, array(), UrlGeneratorInterface::ABSOLUTE_URL), 301);
		}

		// Overwrite the page metadata (see #2853, #4955 and #87)
		$responseContext = System::getContainer()->get('contao.routing.response_context_accessor')->getResponseContext();

		if ($responseContext?->has(HtmlHeadBag::class))
		{
			$htmlHeadBag = $responseContext->get(HtmlHeadBag::class);
			$htmlDecoder = System::getContainer()->get('contao.string.html_decoder');

			if ($objEvent->pageTitle)
			{
				$htmlHeadBag->setTitle($objEvent->pageTitle); // Already stored decoded
			}
			elseif ($objEvent->title)
			{
				$htmlHeadBag->setTitle($htmlDecoder->inputEncodedToPlainText($objEvent->title));
			}

			if ($objEvent->description)
			{
				$htmlHeadBag->setMetaDescription($htmlDecoder->inputEncodedToPlainText($objEvent->description));
			}
			elseif ($objEvent->teaser)
			{
				$htmlHeadBag->setMetaDescription($htmlDecoder->htmlToPlainText($objEvent->teaser));
			}

			if ($objEvent->robots)
			{
				$htmlHeadBag->setMetaRobots($objEvent->robots);
			}

			if ($objEvent->canonicalLink)
			{
				$url = System::getContainer()->get('contao.insert_tag.parser')->replaceInline($objEvent->canonicalLink);

				// Ensure absolute links
				if (!preg_match('#^https?://#', $url))
				{
					if (!$request = System::getContainer()->get('request_stack')->getCurrentRequest())
					{
						throw new \RuntimeException('The request stack did not contain a request');
					}

					$url = UrlUtil::makeAbsolute($url, $request->getUri());
				}

				$htmlHeadBag->setCanonicalUri($url);
			}
			elseif (!$this->cal_keepCanonical)
			{
				$htmlHeadBag->setCanonicalUri($urlGenerator->generate($objEvent, array(), UrlGeneratorInterface::ABSOLUTE_URL));
			}
		}

		$intStartTime = $objEvent->startTime;
		$intEndTime = $objEvent->endTime;
		$span = Calendar::calculateSpan($intStartTime, $intEndTime);

		// Do not show dates in the past if the event is recurring (see #923)
		if ($objEvent->recurring)
		{
			$arrRange = StringUtil::deserialize($objEvent->repeatEach);

			if (isset($arrRange['unit'], $arrRange['value']))
			{
				while (($this->cal_hideRunning ? $intStartTime : $intEndTime) < time() && $intEndTime < $objEvent->repeatEnd)
				{
					$intStartTime = strtotime('+' . $arrRange['value'] . ' ' . $arrRange['unit'], $intStartTime);
					$intEndTime = strtotime('+' . $arrRange['value'] . ' ' . $arrRange['unit'], $intEndTime);
				}
			}
		}

		// Mark past and upcoming events (see #187)
		if ($intEndTime < strtotime('00:00:00'))
		{
			$objEvent->cssClass .= ' bygone';
		}
		elseif ($intStartTime > strtotime('23:59:59'))
		{
			$objEvent->cssClass .= ' upcoming';
		}
		else
		{
			$objEvent->cssClass .= ' current';
		}

		list($strDate, $strTime) = $this->getDateAndTime($objEvent, $objPage, $intStartTime, $intEndTime, $span);

		$until = '';
		$recurring = '';
		$arrRange = array();

		// Recurring event
		if ($objEvent->recurring)
		{
			$arrRange = StringUtil::deserialize($objEvent->repeatEach);

			if (isset($arrRange['unit'], $arrRange['value']))
			{
				if ($arrRange['value'] == 1)
				{
					$repeat = $GLOBALS['TL_LANG']['MSC']['cal_single_' . $arrRange['unit']];
				}
				else
				{
					$repeat = \sprintf($GLOBALS['TL_LANG']['MSC']['cal_multiple_' . $arrRange['unit']], $arrRange['value']);
				}

				if ($objEvent->recurrences > 0)
				{
					$until = ' ' . \sprintf($GLOBALS['TL_LANG']['MSC']['cal_until'], Date::parse($objPage->dateFormat, $objEvent->repeatEnd));
				}

				if ($objEvent->recurrences > 0 && $intEndTime <= time())
				{
					$recurring = \sprintf($GLOBALS['TL_LANG']['MSC']['cal_repeat_ended'], $repeat, $until);
				}
				elseif ($objEvent->addTime)
				{
					$recurring = \sprintf($GLOBALS['TL_LANG']['MSC']['cal_repeat'], $repeat, $until, date('Y-m-d\TH:i:sP', $intStartTime), $strDate . ($strTime ? ' ' . $strTime : ''));
				}
				else
				{
					$recurring = \sprintf($GLOBALS['TL_LANG']['MSC']['cal_repeat'], $repeat, $until, date('Y-m-d', $intStartTime), $strDate);
				}
			}
		}

		$objTemplate = new FrontendTemplate($this->cal_template ?: 'event_full');
		$objTemplate->setData($objEvent->row());
		$objTemplate->date = $strDate;
		$objTemplate->time = $strTime;
		$objTemplate->datetime = $objEvent->addTime ? date('Y-m-d\TH:i:sP', $intStartTime) : date('Y-m-d', $intStartTime);
		$objTemplate->begin = $intStartTime;
		$objTemplate->end = $intEndTime;
		$objTemplate->class = $objEvent->cssClass ? ' ' . trim($objEvent->cssClass) : '';
		$objTemplate->recurring = $recurring;
		$objTemplate->until = $until;
		$objTemplate->locationLabel = $GLOBALS['TL_LANG']['MSC']['location'];
		$objTemplate->calendar = CalendarModel::findById($objEvent->pid);
		$objTemplate->count = 0; // see #74
		$objTemplate->details = '';
		$objTemplate->hasTeaser = false;
		$objTemplate->hasReader = true;

		// Clean the RTE output
		if ($objEvent->teaser)
		{
			$objTemplate->hasTeaser = true;
			$objTemplate->teaser = StringUtil::encodeEmail($objEvent->teaser);
		}

		// Display the "read more" button for external/article links
		if ($objEvent->source != 'default')
		{
			$objTemplate->hasDetails = true;
			$objTemplate->hasReader = false;
		}

		// Compile the event text
		else
		{
			$id = $objEvent->id;

			$objTemplate->details = Template::once(function () use ($id) {
				$strDetails = '';
				$objElement = ContentModel::findPublishedByPidAndTable($id, 'tl_calendar_events');

				if ($objElement !== null)
				{
					while ($objElement->next())
					{
						$strDetails .= $this->getContentElement($objElement->current());
					}
				}

				return $strDetails;
			});

			$objTemplate->hasDetails = Template::once(static function () use ($id) {
				return ContentModel::countPublishedByPidAndTable($id, 'tl_calendar_events') > 0;
			});
		}

		$objTemplate->addImage = false;
		$objTemplate->addBefore = false;

		// Add an image
		if ($objEvent->addImage)
		{
			$imgSize = $objEvent->size ?: null;

			// Override the default image size
			if ($this->imgSize)
			{
				$size = StringUtil::deserialize($this->imgSize);

				if ($size[0] > 0 || $size[1] > 0 || is_numeric($size[2]) || ($size[2][0] ?? null) === '_')
				{
					$imgSize = $this->imgSize;
				}
			}

			$figure = System::getContainer()
				->get('contao.image.studio')
				->createFigureBuilder()
				->from($objEvent->singleSRC)
				->setSize($imgSize)
				->setOverwriteMetadata($objEvent->getOverwriteMetadata())
				->enableLightbox($objEvent->fullsize)
				->buildIfResourceExists();

			$figure?->applyLegacyTemplateData($objTemplate, null, $objEvent->floating);
		}

		$objTemplate->enclosure = array();

		// Add enclosures
		if ($objEvent->addEnclosure)
		{
			$this->addEnclosuresToTemplate($objTemplate, $objEvent->row());
		}

		////////// CHANGES BY ModuleEventReaderTags
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
		////////// CHANGES BY ModuleEventReaderTags
		
		// Add a function to retrieve upcoming dates (see #175)
		$objTemplate->getUpcomingDates = function ($recurrences) use ($objEvent, $arrRange, $intStartTime, $intEndTime, $objPage, $span) {
			if (!$objEvent->recurring || !isset($arrRange['unit'], $arrRange['value']))
			{
				return array();
			}

			$dates = array();
			$startTime = $intStartTime;
			$endTime = $intEndTime;
			$strtotime = '+ ' . $arrRange['value'] . ' ' . $arrRange['unit'];

			for ($i=0; $i<$recurrences; $i++)
			{
				$startTime = strtotime($strtotime, $startTime);
				$endTime = strtotime($strtotime, $endTime);

				if ($endTime > $objEvent->repeatEnd)
				{
					break;
				}

				list($strDate, $strTime) = $this->getDateAndTime($objEvent, $objPage, $startTime, $endTime, $span);

				$dates[] = array
				(
					'date' => $strDate,
					'time' => $strTime,
					'datetime' => $objEvent->addTime ? date('Y-m-d\TH:i:sP', $startTime) : date('Y-m-d', $endTime),
					'begin' => $startTime,
					'end' => $endTime
				);
			}

			return $dates;
		};

		// Add a function to retrieve past dates (see #175)
		$objTemplate->getPastDates = function ($recurrences) use ($objEvent, $arrRange, $intStartTime, $intEndTime, $objPage, $span) {
			if (!$objEvent->recurring || !isset($arrRange['unit'], $arrRange['value']))
			{
				return array();
			}

			$dates = array();
			$startTime = $intStartTime;
			$endTime = $intEndTime;
			$strtotime = '- ' . $arrRange['value'] . ' ' . $arrRange['unit'];

			for ($i=0; $i<$recurrences; $i++)
			{
				$startTime = strtotime($strtotime, $startTime);
				$endTime = strtotime($strtotime, $endTime);

				if ($startTime < $objEvent->startDate)
				{
					break;
				}

				list($strDate, $strTime) = $this->getDateAndTime($objEvent, $objPage, $startTime, $endTime, $span);

				$dates[] = array
				(
					'date' => $strDate,
					'time' => $strTime,
					'datetime' => $objEvent->addTime ? date('Y-m-d\TH:i:sP', $startTime) : date('Y-m-d', $endTime),
					'begin' => $startTime,
					'end' => $endTime
				);
			}

			return $dates;
		};

		// schema.org information
		$objTemplate->getSchemaOrgData = static function () use ($objEvent, $objTemplate): array {
			$jsonLd = Events::getSchemaOrgData($objEvent);

			if ($objTemplate->addImage && $objTemplate->figure)
			{
				$jsonLd['image'] = $objTemplate->figure->getSchemaOrgData();
			}

			return $jsonLd;
		};

		$this->Template->event = $objTemplate->parse();

		// Tag the event (see #2137)
		if (System::getContainer()->has('fos_http_cache.http.symfony_response_tagger'))
		{
			$responseTagger = System::getContainer()->get('fos_http_cache.http.symfony_response_tagger');
			$responseTagger->addTags(array('contao.db.tl_calendar_events.' . $objEvent->id));
		}

		$bundles = System::getContainer()->getParameter('kernel.bundles');

		// HOOK: comments extension required
		if ($objEvent->noComments || !isset($bundles['ContaoCommentsBundle']))
		{
			$this->Template->allowComments = false;

			return;
		}

		if (!$objCalendar = CalendarModel::findById($objEvent->pid))
		{
			return;
		}

		$this->Template->allowComments = $objCalendar->allowComments;

		// Comments are not allowed
		if (!$objCalendar->allowComments)
		{
			return;
		}

		// Adjust the comments headline level
		$intHl = min((int) str_replace('h', '', $this->hl), 5);
		$this->Template->hlc = 'h' . ($intHl + 1);

		$arrNotifies = array();

		// Notify the system administrator
		if ($objCalendar->notify != 'notify_author' && isset($GLOBALS['TL_ADMIN_EMAIL']))
		{
			$arrNotifies[] = $GLOBALS['TL_ADMIN_EMAIL'];
		}

		if ($objCalendar->notify != 'notify_admin' && ($objAuthor = UserModel::findById($objEvent->author)) && $objAuthor->email)
		{
			$arrNotifies[] = $objAuthor->email;
		}

		$objConfig = new \stdClass();

		$objConfig->perPage = $objCalendar->perPage;
		$objConfig->order = $objCalendar->sortOrder;
		$objConfig->template = $this->com_template;
		$objConfig->requireLogin = $objCalendar->requireLogin;
		$objConfig->disableCaptcha = $objCalendar->disableCaptcha;
		$objConfig->bbcode = $objCalendar->bbcode;
		$objConfig->moderate = $objCalendar->moderate;

		(new Comments())->addCommentsToTemplate($this->Template, $objConfig, 'tl_calendar_events', $objEvent->id, $arrNotifies);
	}
}
