<?php

namespace Hschottm\TagsBundle\EventListener\DataContainer;

use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\DataContainer;
use Doctrine\DBAL\Connection;

class PageCallbackListener
{
    public function __construct(
        private readonly Connection $db,
    )
    {
    }

	#[AsCallback(table: 'tl_page', target: 'config.ondelete')]
    public function onDeletePage(DataContainer $dc, int $undoId): void
    {
        if (!$dc->id) {
            return;
        }

		// remove tags of all articles in the page
		$arrArticles = $this->db->executeQuery("SELECT DISTINCT id FROM tl_article WHERE pid = ?", array($dc->id));
		while (($row = $arrArticles->fetchAssociative()) !== false) {
			$arrContentElements = $this->db->executeQuery("SELECT DISTINCT id FROM tl_content WHERE pid = ? AND ptable = 'tl_article'", array($row['id']));
			while (($crow = $arrContentElements->fetchAssociative()) !== false)
			{
				$this->db->executeStatement("DELETE FROM tl_tag WHERE from_table = ? AND tid = ?", array('tl_content', $crow['id']));
			}
			$this->db->executeStatement("DELETE FROM tl_tag WHERE from_table = ? AND tid = ?", array('tl_article', $row['id']));
		}
    }
}
