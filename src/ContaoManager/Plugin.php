<?php

declare(strict_types=1);

/*
 * @copyright  Helmut Schottmüller 2009-2022 <http://github.com/hschottm>
 * @author     Helmut Schottmüller (hschottm)
 * @package    contao-tags
 * @license    LGPL-3.0+, CC-BY-NC-3.0
 * @see	      https://github.com/hschottm/tags
 */

namespace Hschottm\TagsBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Hschottm\TagsBundle\HschottmTagsBundle;

/**
 * Plugin for the Contao Manager.
 *
 * @author Helmut Schottmüller (hschottm)
 */
class Plugin implements BundlePluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBundles(ParserInterface $parser)
    {
        return [
             BundleConfig::create(HschottmTagsBundle::class)
              ->setReplace(['tags']),
         ];
    }
}
