<?php

namespace SymfonyBundles\KafkaBundle\Tests\Integration;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface|null
     */
    protected $container;

    /**
     * {@inheritdoc}
     */
    public function setUp(): void
    {
        $this->container = Kernel::make()->getContainer();
    }
}
