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
        $this->addDefinition($container, Consumer\Consumer::class);
        $this->addDefinition($container, Producer\Producer::class);
        $this->addDefinition($container, Topic\Configuration::class);
        $this->addDefinition($container, Consumer\Configuration::class);
        $this->addDefinition($container, Producer\Configuration::class);
    }

    /**
     * @param ContainerBuilder $container
     * @param string           $className
     */
    protected function addDefinition(ContainerBuilder $container, string $className): void
    {
        $service = new Definition($className);
        $service->setPublic(true);
        $service->setAutowired(true);
        $service->setAutoconfigured(true);

        $container->setDefinition(new Reference($className), $service);
    }
}
