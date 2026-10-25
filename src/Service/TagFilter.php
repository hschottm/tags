<?php

declare(strict_types=1);

namespace Hschottm\TagsBundle\Service;

use Contao\Input;
use Doctrine\DBAL\Connection;
use Hschottm\TagsBundle\TagHelper;

/** Shared filtering for modules and their hooks; no global/current-module state. */
class TagFilter
{
    public function __construct(private readonly Connection $db) {}

    /** Null: no filter. Empty array: active filter without matches. @return list<int>|null */
    public function findIds(string $table, string $configured = '', bool $ignoreRequest = false): ?array
    {
        $ids = null;
        $configuredTags = $this->split($configured);
        if ($configuredTags) {
            $ids = $this->db->fetchFirstColumn('SELECT DISTINCT tid FROM tl_tag WHERE from_table = ? AND tag IN ('.implode(',', array_fill(0, count($configuredTags), '?')).')', [$table, ...$configuredTags]);
        }
        foreach ($this->requestTags($ignoreRequest) as $tag) {
            $matches = $this->db->fetchFirstColumn('SELECT DISTINCT tid FROM tl_tag WHERE from_table = ? AND tag = ?', [$table, $tag]);
            $ids = $ids === null ? $matches : array_values(array_intersect($ids, $matches));
            if (!$ids) break;
        }
        return $ids === null ? null : array_map('intval', $ids);
    }

    /** @return list<string> */
    public function activeTags(string $configured = '', bool $ignoreRequest = false): array
    {
        return array_values(array_unique([...$this->split($configured), ...$this->requestTags($ignoreRequest)]));
    }

    private function requestTags(bool $ignore): array
    {
        $tag = TagHelper::decode(Input::get('tag'));
        return $ignore || $tag === '' ? [] : [$tag, ...$this->split(TagHelper::decode(Input::get('related')))];
    }

    private function split(string $tags): array
    {
        return array_values(array_filter(array_map('trim', explode(',', $tags)), 'strlen'));
    }
}
