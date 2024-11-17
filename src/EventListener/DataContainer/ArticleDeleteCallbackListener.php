<?php

namespace Hschottm\TagsBundle\EventListener\DataContainer;

use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\DataContainer;
use Doctrine\DBAL\Connection;

#[AsCallback(table: 'tl_article', target: 'config.ondelete')]
class ArticleDeleteCallbackListener
{
    private $db;

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    public function __invoke(DataContainer $dc, int $undoId): void
    {
        if (!$dc->id) {
            return;
        }

        $this->db->prepare("DELETE FROM tl_tag WHERE from_table = ? AND tid = ?")
            ->execute($dc->table, $dc->id);
        $arrContentElements = $this->db->prepare("SELECT DISTINCT id FROM tl_content WHERE pid = ?")
            ->execute($dc->id)->fetchEach('id');
        foreach ($arrContentElements as $cte_id)
        {
            $this->db->prepare("DELETE FROM tl_tag WHERE from_table = ? AND tid = ?")
                ->execute('tl_content', $cte_id);
        }
    }
}
