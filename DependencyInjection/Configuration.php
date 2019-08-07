<?php

namespace SymfonyBundles\KafkaBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder(KafkaExtension::EXTENSION_ALIAS);
        $rootNode = $builder->getRootNode();

        $this->addConfigurationSection('topics', $rootNode);
        $this->addConfigurationSection('consumers', $rootNode);
        $this->addConfigurationSection('producers', $rootNode);

        return $builder;
    }

    /**
     * @param string              $nodeName
     * @param ArrayNodeDefinition $rootNode
     */
    private function addConfigurationSection(string $nodeName, ArrayNodeDefinition $rootNode): void
    {
        $node = $rootNode->children()->arrayNode($nodeName)->addDefaultsIfNotSet();

        $this->addVariableNode('configuration', $node)->end();
    }

    /**
     * @param string              $nodeName
     * @param ArrayNodeDefinition $rootNode
     *
     * @return ArrayNodeDefinition
     */
    private function addVariableNode(string $nodeName, ArrayNodeDefinition $rootNode): ArrayNodeDefinition
    {
        return $rootNode->children()->arrayNode($nodeName)->prototype('variable')->end()->end()->end();
    }
}
