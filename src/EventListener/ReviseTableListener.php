<?php

namespace Hschottm\TagsBundle\EventListener;

use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\System;

#[AsHook('reviseTable')]
class ReviseTableListener
{
    public function __invoke(string $table, ?array $newRecords, ?string $parentTable, ?array $childTables): bool
    {
        if (!in_array($table, $GLOBALS['tags_extension']['sourcetable'] ?? [], true)) {
            return false;
        }

        $db = System::getContainer()->get('database_connection');
        $source = $db->quoteIdentifier($table);
        // Remove tags whose source records no longer exist.
        $db->executeStatement("DELETE FROM tl_tag WHERE from_table = ? AND NOT EXISTS (SELECT 1 FROM $source WHERE $source.id = tl_tag.tid)", [$table]);
        return false;
    }
}
