<?php

namespace Hschottm\TagsBundle\EventListener\DataContainer;

use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\DataContainer;
use Doctrine\DBAL\Connection;


class ContentCallbackListener
{
    public function __construct(
        private readonly Connection $db,
    )
    {
    }

    #[AsCallback(table: 'tl_content', target: 'config.oncopy')]
    public function onCopyContent(int $insertId, DataContainer $dc): void
    {
        if (!$dc->id) {
            return;
        }

		$objTags = $this->db->executeQuery("SELECT * FROM tl_tag WHERE tid = ? AND from_table = ?", array($dc->id, $dc->table));
		$tags = array();
        while (($row = $objTags->fetchAssociative()) !== false) {
			\array_push($tags, array("table" => $dc->table, "tag" => $row['tag']));
		}
		foreach ($tags as $entry) {
			$this->db->executeStatement("INSERT INTO tl_tag (tid, tag, from_table) VALUES (?, ?, ?)", array($insertId, $entry['tag'], $entry['table']));
		}
    }

    #[AsCallback(table: 'tl_content', target: 'config.ondelete')]
    public function onDeleteContent(DataContainer $dc, int $undoId): void
    {
        if (!$dc->id) {
            return;
        }

        $this->db->executeStatement("DELETE FROM tl_tag WHERE from_table = ? AND tid = ?", array($dc->table, $dc->id));
    }
}
