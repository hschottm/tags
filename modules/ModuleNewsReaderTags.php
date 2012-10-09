<?php

/**
 * @copyright  Helmut Schottmüller 2009
 * @author     Helmut Schottmüller <typolight@aurealis.de>
 * @package    News
 * @license    LGPL
 * @filesource
 */

namespace Contao;

if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Class ModuleNewsReaderTags
 *
 * Front end module "news reader".
 * @copyright  Helmut Schottmüller 2009
 * @author     Helmut Schottmüller <typolight@aurealis.de>
 * @package    Controller
 */
class ModuleNewsReaderTags extends \ModuleNewsReader
{
	/**
	 * Parse one or more items and return them as array
	 * @param object
	 * @param boolean
	 * @return array
	 */
	protected function parseArticles($objArticles, $blnAddArchive=false)
	{
		$this->Session->set('news_showtags', $this->news_showtags);
		$this->Session->set('news_jumpto', $this->tag_jumpTo);
		$this->Session->set('news_tag_named_class', $this->tag_named_class);
		$result = parent::parseArticles($objArticles, $blnAddArchive);
		$this->Session->set('news_showtags', '');
		$this->Session->set('news_jumpto', '');
		$this->Session->set('news_tag_named_class', '');
		return $result;
	}
}

?>