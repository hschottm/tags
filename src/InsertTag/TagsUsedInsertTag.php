<?php

namespace Hschottm\TagsBundle\InsertTag;

use Contao\CoreBundle\DependencyInjection\Attribute\AsInsertTag;
use Contao\CoreBundle\InsertTag\Exception\InvalidInsertTagException;
use Contao\CoreBundle\InsertTag\InsertTagResult;
use Contao\CoreBundle\InsertTag\OutputType;
use Contao\CoreBundle\InsertTag\ResolvedInsertTag;
use Contao\CoreBundle\InsertTag\Resolver\InsertTagResolverNestedResolvedInterface;
use Contao\Input;
use Contao\FrontendTemplate;
use Hschottm\TagsBundle\TagHelper;

#[AsInsertTag('tags_used')]
class TagsUsedInsertTag implements InsertTagResolverNestedResolvedInterface
{
    public function __invoke(ResolvedInsertTag $insertTag): InsertTagResult
    {
        $parameter = $insertTag->getParameters()->get(0);
        if ($parameter == null) {
            $headlinetags = array();
            $relatedlist = (strlen(TagHelper::decode(Input::get('related')))) ? preg_split("/,/", TagHelper::decode(Input::get('related'))) : array();
            if (strlen(TagHelper::decode(Input::get('tag'))))
            {
                $headlinetags = array_merge($headlinetags, array($this->Input->get('tag')));
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
