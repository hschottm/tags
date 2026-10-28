<?php

namespace Hschottm\TagsBundle\EventListener\DataContainer;

use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\DataContainer;
use Doctrine\DBAL\Connection;

class FileCallbackListener
{
    public function __construct(private readonly Connection $db) {}

    #[AsCallback(table: 'tl_files', target: 'config.oncopy')]
    public function onCopyFile(string $source, string $destination, DataContainer $dc): void
    {
        // DC_Folder passes paths, not record IDs. Include files inside copied folders.
        $files = $this->db->fetchAllAssociative('SELECT id, path FROM tl_files WHERE path = ? OR path LIKE ? ESCAPE \'!\'', [$source, $this->escapeLike($source). '/%']);
        foreach ($files as $file) {
            $targetPath = $destination.substr($file['path'], strlen($source));
            $targetId = $this->db->fetchOne('SELECT id FROM tl_files WHERE path = ?', [$targetPath]);
            if ($targetId) {
                $this->db->executeStatement('INSERT INTO tl_tag (tid, tag, from_table) SELECT ?, tag, from_table FROM tl_tag WHERE tid = ? AND from_table = ?', [$targetId, $file['id'], 'tl_files']);
            }
        }
    }

    #[AsCallback(table: 'tl_files', target: 'config.ondelete')]
    public function onDeleteFile(string $source, DataContainer $dc): void
    {
        $this->db->executeStatement('DELETE FROM tl_tag WHERE from_table = ? AND tid IN (SELECT id FROM tl_files WHERE path = ? OR path LIKE ? ESCAPE \'!\')', ['tl_files', $source, $this->escapeLike($source).'/%']);
    }

    private function escapeLike(string $path): string
    {
        return strtr($path, ['!' => '!!', '%' => '!%', '_' => '!_']);
    }
}
