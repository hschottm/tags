<?php

declare(strict_types=1);

namespace Hschottm\TagsBundle\Service;

use Contao\StringUtil;
use Contao\Environment;
use Hschottm\TagsBundle\TagHelper;
use Hschottm\TagsBundle\TagList;

class TagView
{
    /** Preserve the public template variables used by existing tag templates. */
    public function forRecord(int $id, string $table, mixed $jumpTo, bool $show = true, bool $namedClass = false, bool $preserveQuery = false): array
    {
        $data = ['showTags' => $show, 'showTagClass' => $namedClass, 'tags' => [], 'taglist' => []];
        if (!$show) return $data;

        $page = TagHelper::getPageObj($jumpTo);
        foreach (TagHelper::tagsForIdAndTable($id, $table) as $tag) {
            $label = StringUtil::specialchars($tag);
            $link = $label;
            if ($page) {
                $url = $page->getFrontendUrl('/tag/'.TagHelper::encode($tag));
                // Event tag links historically keep query parameters (e.g. the selected period).
                if ($preserveQuery && ($query = Environment::get('queryString'))) {
                    [$base, $fragment] = array_pad(explode('#', $url, 2), 2, null);
                    $url = $base.(str_contains($base, '?') ? '&' : '?').$query.($fragment !== null ? '#'.$fragment : '');
                }
                $link = '<a href="'.StringUtil::specialchars($url).'">'.$label.'</a>';
            }
            $data['tags'][] = $link;
            $data['taglist'][] = ['url' => $link, 'tag' => $tag, 'class' => TagList::_getTagNameClass($tag)];
        }
        return $data;
    }
}
