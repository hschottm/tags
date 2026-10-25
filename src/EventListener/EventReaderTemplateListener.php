<?php

declare(strict_types=1);

namespace Hschottm\TagsBundle\EventListener;

use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\FrontendTemplate;
use Contao\ModuleEventReader;
use Contao\Template;
use Hschottm\TagsBundle\Service\TagView;

class EventReaderTemplateListener
{
    /** @var list<ModuleEventReader> */
    private array $modules = [];

    public function __construct(private readonly TagView $view) {}

    public function withModule(ModuleEventReader $module, callable $compile): void
    {
        $this->modules[] = $module;
        try {
            $compile();
        } finally {
            // Restore the outer context even for nested readers, redirects and errors.
            array_pop($this->modules);
        }
    }

    #[AsHook('parseTemplate')]
    public function __invoke(Template $template): void
    {
        $module = end($this->modules);
        if (!$module || !$template instanceof FrontendTemplate || $template->getName() !== ($module->cal_template ?: 'event_full')) return;
        // Match the actual event template, not a nested content element with the same name.
        $data = $template->getData(); // Do not invoke lazy schema/content closures.
        if (empty($data['id']) || !($data['getSchemaOrgData'] ?? null) instanceof \Closure || empty($data['calendar'])) return;
        foreach ($this->view->forRecord((int) $template->id, 'tl_calendar_events', $module->tag_jumpTo, (bool) $module->event_showtags, (bool) $module->tag_named_class, true) as $key => $value) {
            $template->$key = $value;
        }
    }
}
