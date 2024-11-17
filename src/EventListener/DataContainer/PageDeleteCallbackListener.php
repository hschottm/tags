<?php

namespace Hschottm\TagsBundle\EventListener\DataContainer;

use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\DataContainer;
use Doctrine\DBAL\Connection;

#[AsCallback(table: 'tl_page', target: 'config.ondelete')]
class PageDeleteCallbackListener
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

		// remove tags of all articles in the page
		$arrArticles = $this->db->prepare("SELECT DISTINCT id FROM tl_article WHERE pid = ?")
			->execute($dc->id)->fetchEach('id');
		foreach ($arrArticles as $id)
		{
			$arrContentElements = $this->db->prepare("SELECT DISTINCT id FROM tl_content WHERE pid = ?")
				->execute($id)->fetchEach('id');
			foreach ($arrContentElements as $cte_id)
			{
				$this->db->prepare("DELETE FROM tl_tag WHERE from_table = ? AND tid = ?")
					->execute('tl_content', $cte_id);
			}
			$this->db->prepare("DELETE FROM tl_tag WHERE from_table = ? AND tid = ?")
				->execute('tl_article', $id);
		}
    }
}
