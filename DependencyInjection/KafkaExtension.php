<?php

namespace SymfonyBundles\KafkaBundle\DependencyInjection;

use SymfonyBundles\KafkaBundle\Topic;
use SymfonyBundles\KafkaBundle\Consumer;
use SymfonyBundles\KafkaBundle\Producer;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

class KafkaExtension extends ConfigurableExtension
{
    public const EXTENSION_ALIAS = 'sb_kafka';

    /**
     * {@inheritdoc}
     */
    public function getAlias(): string
    {
        return static::EXTENSION_ALIAS;
    }

    /**
     * {@inheritdoc}
     */
    protected function loadInternal(array $configs, ContainerBuilder $container)
    {
        $this->addConfiguration(Consumer\Configuration::class, $configs['consumers']['configuration'], $container);
        $this->addConfiguration(Producer\Configuration::class, $configs['producers']['configuration'], $container);

        $this->addServiceDefinition(Consumer\Consumer::class, Consumer\Configuration::class, $container);
        $this->addServiceDefinition(Producer\Producer::class, Producer\Configuration::class, $container);
    }

    /**
     * @param string           $className
     * @param array            $configs
     * @param ContainerBuilder $container
     */
    private function addConfiguration(string $className, array $configs, ContainerBuilder $container): void
    {
        $container->setDefinition(new Reference($className), new Definition($className, [$configs]));
    }

    /**
     * @param string           $className
     * @param string           $configClassName
     * @param ContainerBuilder $container
     */
    private function addServiceDefinition(string $className, string $configClassName, ContainerBuilder $container): void
    {
        $definition = new Definition($className, [new Reference($configClassName)]);
        $definition->setPublic(true);
        $definition->setAutowired(true);
        $definition->setAutoconfigured(true);

        $container->setDefinition(new Reference($className), $definition);
    }
}
