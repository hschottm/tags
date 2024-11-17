<?php

namespace Hschottm\TagsBundle\EventListener;

use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\Database;

#[AsHook('reviseTable')]
class ReviseTableListener
{
    public function __invoke(string $table, ?array $newRecords, ?string $parentTable, ?array $childTables): ?bool
    {
        $reloadTable = false;

        // delete incomplete records
		if (is_array($newRecords))
		{
			foreach ($newRecords as $id)
			{
				$ids = Database::getInstance()->prepare("SELECT tl_tag.tid FROM tl_tag, $table WHERE tl_tag.tid = $table.id AND $table.tstamp = 0")
					->execute()
					->fetchEach('tid');
				if (count($ids))
				{
					Database::getInstance()->prepare("DELETE FROM tl_tag WHERE tid IN (" . implode(",", $ids) . ") AND from_table = ?")
						->execute($table);
                    $reloadTable = true;
				}
			}
		}


        // delete unused tags for table
		$ids = Database::getInstance()->prepare("select DISTINCT tl_tag.tid from tl_tag left join " . $table . " on tl_tag.tid = " . $table . ".id where tl_tag.from_table = ? and " . $table . ".id is null")
			->execute($table)
			->fetchEach('tid');
		foreach ($ids as $id)
		{
			Database::getInstance()->prepare("DELETE FROM tl_tag WHERE tid = ? AND from_table = ?")
				->execute($id, $table);
            $reloadTable = true;
        }
        return $reloadTable;
    }
}
