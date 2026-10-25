<?php

namespace Hschottm\TagsBundle;

use Contao\FaqModel;

/** @deprecated The FAQ module now filters core-generated data. Kept for callers of the old API. */
class TagsFaqModel extends FaqModel
{
    public static function findPublishedByPidsAndIds($arrPids, $arrIds, array $arrOptions = [])
    {
        return parent::findPublishedByPids($arrPids, array_replace($arrOptions, ['tags_ids' => $arrIds]));
    }

    protected static function buildFindQuery(array $arrOptions)
    {
        // Preserve the historical FAQ API: an empty ID list meant no restriction.
        if (!empty($arrOptions['tags_ids'])) {
            $arrOptions['column'] = (array) ($arrOptions['column'] ?? []);
            $arrOptions['column'][] = 'tl_faq.id IN ('.implode(',', array_map('intval', $arrOptions['tags_ids'])).')';
        }
        unset($arrOptions['tags_ids']);
        return parent::buildFindQuery($arrOptions);
    }
}
