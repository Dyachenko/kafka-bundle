<?php

namespace SymfonyBundles\KafkaBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder(KafkaExtension::EXTENSION_ALIAS);

        $builder
            ->getRootNode()
            ->children()
                ->arrayNode('topics')
                    ->children()
                        ->arrayNode('configuration')->prototype('variable')->end()->end()
                    ->end()
                ->end()
                ->arrayNode('consumers')
                    ->children()
                        ->arrayNode('configuration')->prototype('variable')->end()->end()
                    ->end()
                ->end()
                ->arrayNode('producers')
                    ->children()
                        ->arrayNode('configuration')->prototype('variable')->end()->end()
                    ->end()
                ->end()
            ->end();

        return $builder;
    }
}
