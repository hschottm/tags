<?php

/**
 * Contao Open Source CMS - tags extension
 *
 * Copyright (c) 2009-2016 Helmut Schottmüller
 *
 * @license LGPL-3.0+
 */

namespace Contao;

class ContentHeadlineTags extends \ContentHeadline
{
	/**
	 * Parse the template
	 * @return string
	 */
	public function generate()
	{
		if (TL_MODE == 'FE') if ($this->tagsonly) if (!strlen(urldecode(\Input::get('tag', true)))) return;
		return parent::generate();
	}
}

