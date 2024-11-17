<?php

namespace Hschottm\TagsBundle;

use Contao\ModuleNewsReader;

/**
 * Contao Open Source CMS - tags extension
 *
 * Copyright (c) 2008-2024 Helmut Schottmüller
 *
 * @license LGPL-3.0+
 */

class ModuleNewsReaderTags extends ModuleNewsReader
{
	/**
	 * Parse one or more items and return them as array
	 * @param object
	 * @param boolean
	 * @return array
	 */
	protected function compile()
	{
		TagHelper::$config['news_showtags'] = $this->news_showtags;
		TagHelper::$config['news_jumpto'] = $this->tag_jumpTo;
		TagHelper::$config['news_tag_named_class'] = $this->tag_named_class;
		parent::compile();
	}
}

