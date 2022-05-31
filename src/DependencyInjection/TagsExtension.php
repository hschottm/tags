<?php

/*
 * @copyright  Helmut Schottmüller 2009-2022 <http://github.com/hschottm>
 * @author     Helmut Schottmüller (hschottm)
 * @package    contao-tags
 * @license    LGPL-3.0+, CC-BY-NC-3.0
 * @see	      https://github.com/hschottm/tags
 */

namespace Hschottm\TagsBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class TagsExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $mergedConfig, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );

        //$loader->load('listener.yml');
        $loader->load('services.yml');
    }
}
