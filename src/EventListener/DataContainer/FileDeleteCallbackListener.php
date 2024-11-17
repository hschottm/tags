<?php

namespace Hschottm\TagsBundle\EventListener\DataContainer;

use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\DataContainer;
use Doctrine\DBAL\Connection;
use Contao\FilesModel;

#[AsCallback(table: 'tl_files', target: 'config.ondelete')]
class FileDeleteCallbackListener
{
    private $db;

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    public function __invoke(string $source, DataContainer $dc): void
    {
        if (!$dc->id) {
            return;
        }

        $fileModel = FilesModel::findByPath($source);
		if ($fileModel != null) {
            $this->db->prepare("DELETE FROM tl_tag WHERE from_table = ? AND tid = ?")
            ->execute($dc->table, $fileModel->id);
        }
    }
}
