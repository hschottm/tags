<?php

namespace Hschottm\TagsBundle;

use \Contao\ContentGallery;
use \Contao\Input;
use \Contao\Database;
use Contao\FilesModel;

/**
 * Contao Open Source CMS - tags extension
 *
 * Copyright (c) 2008-2024 Helmut Schottmüller
 *
 * @license LGPL-3.0+
 */

class ContentGalleryTags extends ContentGallery
{
	/**
	 * Generate the content element
	 */
	public function compile()
	{
		$newMultiSRC = array();

        $tagids = TagHelper::findTaggedIds('tl_files', (string) $this->tag_filter, (bool) $this->tag_ignore);
        if ($tagids !== null && $this->objFiles !== null) {
			while ($this->objFiles->next()) {
				if ($this->objFiles->type == 'file') {
					if (in_array($this->objFiles->id, $tagids)) \array_push($newMultiSRC, $this->objFiles->uuid);
				} else {
					$objSubfiles = FilesModel::findByPid($this->objFiles->uuid);
					if ($objSubfiles === null) {
						continue;
					}

					while ($objSubfiles->next()) {
						if (in_array($objSubfiles->id, $tagids)) \array_push($newMultiSRC, $objSubfiles->uuid);
					}
				}
			}
			$this->multiSRC = $newMultiSRC;
			$this->objFiles = FilesModel::findMultipleByUuids($this->multiSRC);
			if ($this->objFiles === null) {
				return '';
			}
		}
		parent::compile();
	}

	protected function getFilterTags()
	{
		if (strlen($this->tag_filter)) {
			$tags = preg_split("/,/", $this->tag_filter);
			$placeholders = array();
			foreach ($tags as $tag) {
				$placeholders[] = '?';
			}
			return Database::getInstance()->prepare("SELECT tid FROM tl_tag WHERE tag IN (" . implode(',', $placeholders) . ") AND from_table = ? ORDER BY tag ASC")
				->execute(...array_merge($tags, ['tl_files']))
				->fetchEach('tid');
		} else {
			return array();
		}
	}
}
