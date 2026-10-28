<?php

namespace Hschottm\TagsBundle;

use Contao\ModuleFaqList;

class ModuleFaqListTags extends ModuleFaqList
{
    protected function compile()
    {
        $ids = TagHelper::findTaggedIds('tl_faq');
        if ($ids === []) {
            $this->Template->faq = [];
            return;
        }
        // The core FAQ list has no pagination. Filtering its structured template
        // data is safe here; the core retains URLs, publication rules and cache tags.
        parent::compile();
        $groups = [];
        foreach ($this->Template->faq as $group) {
            if ($ids !== null) {
                $group['items'] = array_values(array_filter($group['items'], static fn ($item) => in_array((int) $item['id'], $ids, true)));
            }
            if ($group['items']) $groups[] = $group;
        }
        // Keep the legacy Tags template variables; core Twig templates use loop metadata.
        foreach ($groups as $index => &$group) {
            $group['class'] = self::legacyClasses($index, count($groups));
            foreach ($group['items'] as $itemIndex => &$item) {
                $item['class'] = self::legacyClasses($itemIndex, count($group['items']));
            }
            unset($item);
        }
        unset($group);
        $this->Template->faq = $groups;
    }

    private static function legacyClasses(int $index, int $count): string
    {
        return trim(($index === 0 ? ' first' : '').($index === $count - 1 ? ' last' : '').($index % 2 === 0 ? ' odd' : ' even'));
    }
}
