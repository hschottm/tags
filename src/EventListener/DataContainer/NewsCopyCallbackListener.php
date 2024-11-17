<?php

namespace Hschottm\TagsBundle\EventListener\DataContainer;

use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\DataContainer;
use Doctrine\DBAL\Connection;

#[AsCallback(table: 'tl_news', target: 'config.oncopy')]
class NewsCopyCallbackListener
{
    private $db;

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    public function __invoke(int $insertId, DataContainer $dc): void
    {
        if (!$dc->id) {
            return;
        }

		$objTags = $this->db->prepare("SELECT * FROM tl_tag WHERE tid = ? AND from_table = ?")->execute($dc->id, $dc->table);
		$tags = array();
		while ($objTags->next()) {
			\array_push($tags, array("table" => $dc->table, "tag" => $objTags->tag));
		}
		foreach ($tags as $entry) {
			$this->db->prepare("INSERT INTO tl_tag (tid, tag, from_table) VALUES (?, ?, ?)")->execute($insertId, $entry['tag'], $entry['table']);
		}
    }
}
