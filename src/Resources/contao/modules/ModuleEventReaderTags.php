<?php

namespace Hschottm\TagsBundle;

use Contao\ModuleEventReader;
use Contao\System;
use Hschottm\TagsBundle\EventListener\EventReaderTemplateListener;

class ModuleEventReaderTags extends ModuleEventReader
{
    protected function compile()
    {
        // parseTemplate has no module argument. Scope its listener to this core
        // compile() call instead of copying the reader implementation.
        System::getContainer()->get(EventReaderTemplateListener::class)
            ->withModule($this, fn () => parent::compile());
    }
}
