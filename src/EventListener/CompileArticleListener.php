<?php

namespace Hschottm\TagsBundle\EventListener;

use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\FrontendTemplate;
use Contao\Module;
use Hschottm\TagsBundle\TagHelper;

#[AsHook('compileArticle')]
class CompileArticleListener
{
    public function __invoke(FrontendTemplate $template, array $data, Module $module): void
    {
		$template->show_tags = $module->tags_showtags;
		if ($module->tags_showtags)
		{
			$template->tags = TagHelper::tagsForArticle($module, $module->tags_max_tags, $module->tags_relevance, $module->tags_jumpto);
		}
    }
}
