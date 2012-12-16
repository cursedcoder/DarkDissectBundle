<?php

namespace Dark\DissectBundle\Builder;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class LanguageConfiguration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('language');

        $rootNode
            ->children()
                ->arrayNode('lexis')
                    ->children()
                        ->arrayNode('regex')->isRequired()
                            ->prototype('scalar')->end()
                        ->end()
                        ->arrayNode('tokens')->isRequired()
                            ->prototype('scalar')->end()
                        ->end()
                        ->arrayNode('skip')
                            ->prototype('scalar')->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('grammar')
                    ->children()
                        ->scalarNode('start_rule')->end()
                        ->scalarNode('default_context')->isRequired()->end()
                        ->arrayNode('rules')
                            ->prototype('array')
                                ->prototype('array')
                                    ->children()
                                        ->arrayNode('statement')->isRequired()
                                            ->prototype('scalar')->end()
                                        ->end()
                                        ->arrayNode('call')
                                            ->children()
                                                ->scalarNode('context')->end()
                                                ->scalarNode('method')->end()
                                            ->end()
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
