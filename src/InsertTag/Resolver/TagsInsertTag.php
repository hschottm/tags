<?php

namespace Hschottm\TagsBundle\InsertTag\Resolver;

use Contao\CoreBundle\DependencyInjection\Attribute\AsInsertTag;
use Contao\CoreBundle\InsertTag\Exception\InvalidInsertTagException;
use Contao\CoreBundle\Framework\ContaoFramework;
use Contao\CoreBundle\InsertTag\InsertTagResult;
use Contao\CoreBundle\InsertTag\OutputType;
use Contao\CoreBundle\InsertTag\ResolvedInsertTag;
use Hschottm\TagsBundle\TagHelper;
use Contao\Input;
use Contao\FrontendTemplate;

class TagsInsertTag 
{
    public function __construct() {
    }

    #[AsInsertTag('tags_article')]
    #[AsInsertTag('tags_article_url')]
    #[AsInsertTag('tags_content')]
    #[AsInsertTag('tags_event')]
    #[AsInsertTag('tags_faq')]
    #[AsInsertTag('tags_file')]
    #[AsInsertTag('tags_news')]
    public function replaceInsertTag(ResolvedInsertTag $insertTag): InsertTagResult
    {
        if (null === $insertTag->getParameters()->get(0)) {
            throw new InvalidInsertTagException('Missing parameters for insert tag.');
        }
        
        $parameter = $insertTag->getParameters()->get(0);

        return match ($insertTag->getName()) {
            'tags_article' => new InsertTagResult(TagHelper::tagsForTableAndId('tl_article', $parameter, false), OutputType::text),
            'tags_article_url' => new InsertTagResult(TagHelper::tagsForTableAndId('tl_article_url', $parameter, false), OutputType::text),
            'tags_content' => new InsertTagResult(TagHelper::tagsForTableAndId('tl_content', $parameter, false), OutputType::text),
            'tags_event' => new InsertTagResult(TagHelper::tagsForTableAndId('tl_calendar_events', $parameter, false), OutputType::text),
            'tags_faq' => new InsertTagResult(TagHelper::tagsForTableAndId('tl_faq', $parameter, false), OutputType::text),
            'tags_file' => new InsertTagResult(TagHelper::tagsForTableAndId('tl_files', $parameter, false), OutputType::text),
            'tags_news' => new InsertTagResult(TagHelper::tagsForTableAndId('tl_news', $parameter, false), OutputType::text),
            default => throw new InvalidInsertTagException(),
        };

    }

    #[AsInsertTag('tags_used')]
    public function replaceInsertTagWithoutParameters(ResolvedInsertTag $insertTag): InsertTagResult
    {
        $parameter = $insertTag->getParameters()->get(0);
        if ($parameter == null) {
            $headlinetags = array();
            $relatedlist = (strlen(TagHelper::decode(Input::get('related')))) ? preg_split("/,/", TagHelper::decode(Input::get('related'))) : array();
            if (strlen(TagHelper::decode(Input::get('tag'))))
            {
                $headlinetags = array_merge($headlinetags, array(Input::get('tag')));
                if (count($relatedlist))
                {
                    $headlinetags = array_merge($headlinetags, $relatedlist);
                }
            }
            if (count($headlinetags))
            {
                $objTemplate = new FrontendTemplate('tags_used');
                $objTemplate->tags = $headlinetags;
                return new InsertTagResult($objTemplate->parse(), OutputType::text);
            } else {
                return new InsertTagResult("", OutputType::text);
            }
        } else {
            $headlinetags = array();
            $relatedlist = (strlen(TagHelper::decode(Input::get('related')))) ? preg_split("/,/", TagHelper::decode(Input::get('related'))) : array();
            if (strlen(TagHelper::decode(Input::get('tag'))))
            {
                $headlinetags = array_merge($headlinetags, array(Input::get('tag')));
                if (count($relatedlist))
                {
                    $headlinetags = array_merge($headlinetags, $relatedlist);
                }
            }
            if (count($headlinetags))
            {
                return new InsertTagResult($parameter, OutputType::text);
            } else {
                return new InsertTagResult("", OutputType::text);
            }
        }
    }
}
