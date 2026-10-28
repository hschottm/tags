<?php

namespace Hschottm\TagsBundle\EventListener;

use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\FrontendTemplate;
use Contao\Module;
use Hschottm\TagsBundle\Service\TagView;

#[AsHook('parseArticles')]
class ParseArticlesListener
{
    public function __construct(private readonly TagView $view) {}

    public function __invoke(FrontendTemplate $template, array $newsEntry, Module $module): void
    {
        foreach ($this->view->forRecord((int) $newsEntry['id'], 'tl_news', $module->tag_jumpTo, (bool) $module->news_showtags, (bool) $module->tag_named_class) as $key => $value) {
            $template->$key = $value;
        }
    }
}
