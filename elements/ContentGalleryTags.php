<?php

namespace Contao;

/**
 * Class ContentGalleryTags
 *
 * Provide methods to handle tag input fields.
 * @copyright  Helmut Schottmüller 2013
 * @author     Helmut Schottmüller <https://github.com/hschottm/>
 * @package    Controller
 */
class ContentGalleryTags extends ContentGallery
{
	/**
	 * Return if there are no files
	 * @return string
	 */
	public function generate()
	{
		// Use the home directory of the current user as file source
		if ($this->useHomeDir && FE_USER_LOGGED_IN)
		{
			$this->import('FrontendUser', 'User');

			if ($this->User->assignDir && $this->User->homeDir)
			{
				$this->multiSRC = array($this->User->homeDir);
			}
		}
		else
		{
			$this->multiSRC = deserialize($this->multiSRC);
		}

		// Return if there are no files
		if (!is_array($this->multiSRC) || empty($this->multiSRC))
		{
			return '';
		}

		// Check for version 3 format
		if (!is_numeric($this->multiSRC[0]))
		{
			return '<p class="error">'.$GLOBALS['TL_LANG']['ERR']['version2format'].'</p>';
		}

		$newMultiSRC = array();
		// Get the file entries from the database
		$this->objFiles = \FilesModel::findMultipleByIds($this->multiSRC);

		if ($this->objFiles === null)
		{
			return '';
		}

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
						$tagids = $this->Database->prepare("SELECT id FROM tl_tag WHERE from_table = ? AND tag = ? AND id IN (" . join($tagids, ",") . ")")
							->execute('tl_files', $tag)
							->fetchEach('id');
					}
					else if ($first)
					{
						$tagids = $this->Database->prepare("SELECT id FROM tl_tag WHERE from_table = ? AND tag = ?")
							->execute('tl_files', $tag)
							->fetchEach('id');
						$first = false;
					}
				}
			}
			while ($this->objFiles->next())
			{
				if ($this->objFiles->type == 'file')
				{
					if (in_array($this->objFiles->id, tagids)) array_push($newMultiSRC, $this->objFiles->id);
				}
				else
				{
					$objSubfiles = \FilesModel::findByPid($this->objFiles->id);
					if ($objSubfiles === null)
					{
						continue;
					}

					while ($objSubfiles->next())
					{
						if (in_array($objSubfiles->id, $tagids)) array_push($newMultiSRC, $objSubfiles->id);
					}
				}
			}
			$this->multiSRC = $newMultiSRC;
			$this->objFiles = \FilesModel::findMultipleByIds($this->multiSRC);
		}

		if ($this->objFiles === null)
		{
			return '';
		}

		return parent::generate();
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
			return $this->Database->prepare("SELECT id FROM tl_tag WHERE tag IN (" . join($placeholders, ',') . ") AND from_table = ? ORDER BY tag ASC")
				->execute($tags)
				->fetchEach('id');
		}
		else
		{
			return array();
		}
	}
	
}
