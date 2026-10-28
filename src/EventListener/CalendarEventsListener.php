<?php

declare(strict_types=1);

namespace Hschottm\TagsBundle\EventListener;

use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\Module;
use Contao\ModuleCalendar;
use Contao\ModuleEventlist;
use Hschottm\TagsBundle\Service\TagFilter;
use Hschottm\TagsBundle\Service\TagView;

#[AsHook('getAllEvents')]
class CalendarEventsListener
{
    public function __construct(private readonly TagFilter $filter, private readonly TagView $view) {}

    public function __invoke(array $events, array $calendars, int $start, int $end, Module $module): array
    {
        // The hook also runs for feeds; do not apply page/module tag filters to those.
        if (!$module instanceof ModuleCalendar && !$module instanceof ModuleEventlist) return $events;
        $ids = $this->filter->findIds('tl_calendar_events', (string) $module->tag_filter, (bool) $module->tag_ignore);
        $show = $module instanceof ModuleCalendar || (bool) $module->event_showtags;
        $views = [];
        foreach ($events as $day => $times) {
            foreach ($times as $time => $items) {
                foreach ($items as $key => $event) {
                    $id = (int) $event['id'];
                    if ($ids !== null && !in_array($id, $ids, true)) {
                        unset($events[$day][$time][$key]);
                        continue;
                    }
                    $views[$id] ??= $this->view->forRecord($id, 'tl_calendar_events', $module instanceof ModuleCalendar ? $module->jumpTo : $module->tag_jumpTo, $show, (bool) $module->tag_named_class, true);
                    $events[$day][$time][$key] = array_replace($event, $views[$id]);
                }
                if (!$events[$day][$time]) unset($events[$day][$time]);
            }
            if (!$events[$day]) unset($events[$day]);
        }
        return $events;
    }
}
