<?php

namespace Dark\DissectBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Bundle's configuration
 *
 * @author Evgeniy Guseletov <d46k16@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('dark_dissect');

        $rootNode
            ->prototype('array')
                ->children()
                ->scalarNode('path')->isRequired()->end()
                ->scalarNode('cache')->defaultTrue()->end()
            ->end();

        return $treeBuilder;
    }
}
