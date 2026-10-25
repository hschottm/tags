<?php

declare(strict_types=1);

namespace Hschottm\TagsBundle\EventListener;

use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\Module;
use Hschottm\TagsBundle\Service\TagFilter;
use Hschottm\TagsBundle\TagsNewsModel;

class NewsListListener
{
    public function __construct(private readonly TagFilter $filter) {}

    #[AsHook('newsListCountItems')]
    public function countItems(array $archives, ?bool $featured, Module $module): int|false
    {
        $ids = $this->filter->findIds('tl_news', (string) $module->tag_filter, (bool) $module->tag_ignore);
        if ($ids === null) return false; // Let Contao and other hooks handle unfiltered lists.
        $count = (int) TagsNewsModel::countPublishedByPidsAndIds($archives, $ids, $featured);
        $module->tags_total_found = $count;
        return $count;
    }

    #[AsHook('newsListFetchItems')]
    public function fetchItems(array $archives, ?bool $featured, int $limit, int $offset, Module $module): mixed
    {
        $ids = $this->filter->findIds('tl_news', (string) $module->tag_filter, (bool) $module->tag_ignore);
        if ($ids === null) return false;

        // UPSTREAM ADAPTATION: Contao 5.7.15, news-bundle/contao/modules/ModuleNewsList.php,
        // ModuleNewsList::fetchItems(), "Determine sorting" block. The hook runs before
        // core sorting, so reproduce only that mapping, not compile()/pagination.
        // See docs/UPSTREAM.md and tests/upstream.php when updating Contao.
        $order = match ($module->news_order) {
            'order_headline_asc' => 'tl_news.headline',
            'order_headline_desc' => 'tl_news.headline DESC',
            'order_random' => 'RAND()',
            'order_date_asc' => 'tl_news.date',
            default => 'tl_news.date DESC',
        };
        if ($module->news_featured === 'featured_first') $order = 'tl_news.featured DESC, '.$order;
        // TAGS: constrain the data source; limit/offset are calculated by Contao.
        return TagsNewsModel::findPublishedByPidsAndIds($archives, $ids, $featured, $limit, $offset, ['order' => $order]);
    }
}
