<?php

namespace Hschottm\TagsBundle\EventListener\DataContainer;

use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\DataContainer;
use Doctrine\DBAL\Connection;
use Symfony\Contracts\Translation\TranslatorInterface;


class FileCallbackListener
{
    public function __construct(
        private readonly TranslatorInterface $translator, 
        private readonly Connection $db,
    )
    {
    }

    #[AsCallback(table: 'tl_files', target: 'config.oncopy')]
    public function onCopyFile(int $insertId, DataContainer $dc): void
    {
        if (!$dc->id) {
            return;
        }

        //$sourceModel = FilesModel::findByPath($source);
        //$destModel = FilesModel::findByPath($destination);

        //if ($sourceModel != null && $destModel != null) {
            //$objTags = $this->db->prepare("SELECT * FROM tl_tag WHERE tid = ? AND from_table = ?")->execute($sourceModel->id, $dc->table);
            $objTags = $this->db->prepare("SELECT * FROM tl_tag WHERE tid = ? AND from_table = ?")->executeQuery(array($dc->id, $dc->table));
            $tags = array();
            while (($row = $objTags->fetchAssociative()) !== false) {
                \array_push($tags, array("table" => $dc->table, "tag" => $row['tag']));
            }
            foreach ($tags as $entry) {
//                $this->db->prepare("INSERT INTO tl_tag (tid, tag, from_table) VALUES (?, ?, ?)")->execute($destModel->id, $entry['tag'], $entry['table']);
                $this->db->prepare("INSERT INTO tl_tag (tid, tag, from_table) VALUES (?, ?, ?)")->executeQuery(array($insertId, $entry['tag'], $entry['table']));
            }
        //}
    }

    #[AsCallback(table: 'tl_files', target: 'config.ondelete')]
    public function onDeleteFile(string $source, DataContainer $dc): void
    {
        if (!$dc->id) {
            return;
        }

        $fileModel = FilesModel::findByPath($source);
		if ($fileModel != null) {
            $this->db->prepare("DELETE FROM tl_tag WHERE from_table = ? AND tid = ?")
            ->executeQuery(array($dc->table, $fileModel->id));
        }
    }
}
