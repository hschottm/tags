<?php

namespace Hschottm\TagsBundle\EventListener;

use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\FrontendTemplate;
use Contao\Module;
use Contao\StringUtil;
use Hschottm\TagsBundle\TagHelper;
use Hschottm\TagsBundle\TagList;

#[AsHook('parseArticles')]
class ParseArticlesListener
{
    public function __invoke(FrontendTemplate $template, array $newsEntry, Module $module): void
    {
		global $objPage;
		$news_showtags = TagHelper::$config['news_showtags'] ?? null;
		$news_jumpto = TagHelper::$config['news_jumpto'] ?? null;
		$tag_named_class = TagHelper::$config['news_tag_named_class'] ?? null;
		if ($news_showtags)
		{
			$pageObj = TagHelper::getPageObj($news_jumpto);
			$tags = TagHelper::tagsForIdAndTable($newsEntry['id'], 'tl_news');
			$taglist = array();
			foreach ($tags as $id => $tag)
			{
				$strUrl = StringUtil::ampersand($pageObj->getFrontendUrl('/tag/' . TagHelper::encode($tag)));
				$tags[$id] = '<a href="' . $strUrl . '">' . StringUtil::specialchars($tag) . '</a>';
				$taglist[$id] = array(
					'url' => $tags[$id],
					'tag' => $tag,
					'class' => TagList::_getTagNameClass($tag)
				);
			}
			$template->showTags = 1;
			$template->showTagClass = $tag_named_class;
			$template->tags = $tags;
			$template->taglist = $taglist;
		}
    }
}
