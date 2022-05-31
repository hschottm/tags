<?php

declare(strict_types=1);

/*
 * @copyright  Helmut Schottmüller 2009-2022 <http://github.com/hschottm>
 * @author     Helmut Schottmüller (hschottm)
 * @package    contao-tags
 * @license    LGPL-3.0+, CC-BY-NC-3.0
 * @see	      https://github.com/hschottm/tags
 */

namespace Hschottm\TagsBundle;

use Hschottm\TagsBundle\DependencyInjection\TagsExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class HschottmTagsBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new TagsExtension();
    }
}
