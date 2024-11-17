<?php

/**
 * Contao Open Source CMS - tags extension
 *
 * Copyright (c) 2009-2024 Helmut Schottmüller
 *
 * @license LGPL-3.0+
 */

 namespace Hschottm\TagsBundle;

 use \Contao\ContentHeadline;
 use \Contao\Input;

class ContentHeadlineTags extends ContentHeadline
{
	/**
	 * Parse the template
	 * @return string
	 */
	public function generate()
	{
		$request = \Contao\System::getContainer()->get('request_stack')->getCurrentRequest();
		if ($request && \Contao\System::getContainer()->get('contao.routing.scope_matcher')->isFrontendRequest($request)) {
			if ($this->tagsonly) if (!strlen(TagHelper::decode(Input::get('tag')))) return;
		}
		return parent::generate();
	}
}

