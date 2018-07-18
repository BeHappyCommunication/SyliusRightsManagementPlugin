<?php

declare(strict_types=1);

namespace BeHappy\SyliusRightsManagementPlugin\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 * @package BeHappy\SyliusRightsManagementPlugin\DependencyInjection
 */
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
                                ->arrayNode('routes')
                                    ->scalarPrototype()->end()
                            ->end()
                                ->arrayNode('exclude')
                                    ->scalarPrototype()->end()
                            ->end()
                                ->scalarNode('redirect_to')->end()
                                ->scalarNode('redirect_message')->end()
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
