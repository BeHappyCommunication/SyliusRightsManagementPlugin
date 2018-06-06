<?php

declare(strict_types=1);

namespace BeHappy\SyliusRightsManagementPlugin\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('behappy_rights_management_plugin');

        $rootNode
            ->children()
                ->arrayNode('rights')
                    ->arrayPrototype()
                        ->arrayPrototype()
                            ->children()
                                ->scalarNode('name')->end()
                                ->scalarNode('route')->end()
                                ->booleanNode('default_granted')
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
