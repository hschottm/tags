<?php

namespace Hschottm\TagsBundle;

use Contao\ModuleNewsList;
use Contao\System;
use Hschottm\TagsBundle\Service\TagFilter;

class ModuleNewsListTags extends ModuleNewsList
{
    protected function compile()
    {
        $this->tags_total_found = null;
        // Contao owns fetching, sorting and pagination. NewsListListener supplies
        // filtered count/items through the two official news-list hooks.
        parent::compile();
        $this->Template->tags_total_found = $this->tags_total_found;
        $this->Template->tags_activetags = System::getContainer()->get(TagFilter::class)
            ->activeTags((string) $this->tag_filter, (bool) $this->tag_ignore);
    }
}
