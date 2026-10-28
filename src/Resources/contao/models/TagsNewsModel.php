<?php

namespace Hschottm\TagsBundle;

use Contao\NewsModel;

/**
 * Add an ID constraint at the query-builder seam. All publication, preview,
 * featured and date-range rules remain in the installed Contao NewsModel.
 * The option is passed per query, never through a static/global filter context.
 */
class TagsNewsModel extends NewsModel
{
    public static function countPublishedByPidsAndIds($arrPids, $arrIds, $blnFeatured = null)
    {
        return parent::countPublishedByPids($arrPids, $blnFeatured, ['tags_ids' => $arrIds]);
    }

    public static function findPublishedByPidsAndIds($arrPids, $arrIds, $blnFeatured = null, $intLimit = 0, $intOffset = 0, array $arrOptions = [])
    {
        return parent::findPublishedByPids($arrPids, $blnFeatured, $intLimit, $intOffset, array_replace($arrOptions, ['tags_ids' => $arrIds]));
    }

    public static function countPublishedFromToByPidsAndIds($intFrom, $intTo, $arrPids, $arrIds)
    {
        return parent::countPublishedFromToByPids($intFrom, $intTo, $arrPids, ['tags_ids' => $arrIds]);
    }

    public static function findPublishedFromToByPidsAndIds($intFrom, $intTo, $arrPids, $arrIds, $intLimit = 0, $intOffset = 0, array $arrOptions = [])
    {
        return parent::findPublishedFromToByPids($intFrom, $intTo, $arrPids, $intLimit, $intOffset, array_replace($arrOptions, ['tags_ids' => $arrIds]));
    }

    protected static function buildFindQuery(array $arrOptions)
    {
        return parent::buildFindQuery(self::addTagConstraint($arrOptions));
    }

    protected static function buildCountQuery(array $arrOptions)
    {
        return parent::buildCountQuery(self::addTagConstraint($arrOptions));
    }

    private static function addTagConstraint(array $options): array
    {
        if (array_key_exists('tags_ids', $options)) {
            $ids = array_map('intval', $options['tags_ids']);
            $options['column'] = (array) ($options['column'] ?? []);
            $options['column'][] = $ids ? 'tl_news.id IN ('.implode(',', $ids).')' : '1=0';
            unset($options['tags_ids']);
        }
        return $options;
    }
}
