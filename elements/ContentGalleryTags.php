<?php

namespace Contao;

/**
 * Contao Open Source CMS - tags extension
 *
 * Copyright (c) 2008-2016 Helmut Schottmüller
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

		if ((strlen(\Input::get('tag')) && (!$this->tag_ignore)) || (strlen($this->tag_filter)))
		{
			$tagids = array();

			$relatedlist = (strlen(\Input::get('related'))) ? preg_split("/,/", \Input::get('related')) : array();
			$alltags = array_merge(array(\Input::get('tag')), $relatedlist);
			$first = true;
			if (strlen($this->tag_filter))
			{
				$headlinetags = preg_split("/,/", $this->tag_filter);
				$tagids = $this->getFilterTags();
				$first = false;
			}
			else
			{
				$headlinetags = array();
			}
			foreach ($alltags as $tag)
			{
				if (strlen(trim($tag)))
				{
					if (count($tagids))
					{
						$tagids = $this->Database->prepare("SELECT tid FROM tl_tag WHERE from_table = ? AND tag = ? AND tid IN (" . join($tagids, ",") . ")")
							->execute('tl_files', $tag)
							->fetchEach('tid');
					}
					else if ($first)
					{
						$tagids = $this->Database->prepare("SELECT tid FROM tl_tag WHERE from_table = ? AND tag = ?")
							->execute('tl_files', $tag)
							->fetchEach('tid');
						$first = false;
					}
				}
			}
			while ($this->objFiles->next())
			{
				if ($this->objFiles->type == 'file')
				{
					if (in_array($this->objFiles->id, $tagids)) array_push($newMultiSRC, $this->objFiles->uuid);
				}
				else
				{
					$objSubfiles = \FilesModel::findByPid($this->objFiles->uuid);
					if ($objSubfiles === null)
					{
						continue;
					}

					while ($objSubfiles->next())
					{
						if (in_array($objSubfiles->id, $tagids)) array_push($newMultiSRC, $objSubfiles->uuid);
					}
				}
			}
			$this->multiSRC = $newMultiSRC;
			$this->objFiles = \FilesModel::findMultipleByUuids($this->multiSRC);
			if ($this->objFiles === null)
			{
				return '';
			}
		}
		parent::compile();
	}

  public static function addImageToTemplate($objTemplate, $arrItem, $intMaxWidth=null, $strLightboxId=null)
  {
      \Controller::addImageToTemplate($objTemplate, $arrItem, $intMaxWidth, $strLightboxId);
      if (TL_MODE == 'FE')
      {
        $found = \TagModel::findByIdAndTable($arrItem['id'], 'tl_files');
        $tags = array();
        if ($found && $found->count())
        {
          while ($found->next())
          {
            array_push($tags, $found->tag);
          }
          $objTemplate->tags = $tags;
        }
      }
  }

	protected function getFilterTags()
	{
		if (strlen($this->tag_filter))
		{
			$tags = preg_split("/,/", $this->tag_filter);
			$placeholders = array();
			foreach ($tags as $tag)
			{
				array_push($placeholders, '?');
			}
			array_push($tags, 'tl_files');
			return $this->Database->prepare("SELECT tid FROM tl_tag WHERE tag IN (" . join($placeholders, ',') . ") AND from_table = ? ORDER BY tag ASC")
				->execute($tags)
				->fetchEach('tid');
		}
		else
		{
			return array();
		}
	}

}
