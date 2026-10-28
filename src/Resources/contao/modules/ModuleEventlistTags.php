<?php

namespace Hschottm\TagsBundle;

use Contao\ModuleEventlist;
use Contao\System;
use Hschottm\TagsBundle\Service\TagFilter;

class ModuleEventlistTags extends ModuleEventlist
{
    protected function compile()
    {
        // getAllEvents supplies filtered events and tag template variables before
        // the core handles recurring events, pagination and template rendering.
        parent::compile();
        $this->Template->tags_activetags = System::getContainer()->get(TagFilter::class)
            ->activeTags((string) $this->tag_filter, (bool) $this->tag_ignore);
    }
}
