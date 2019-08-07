<?php

namespace SymfonyBundles\KafkaBundle\Tests\Integration\DependencyInjection\Traits;

use SymfonyBundles\KafkaBundle\Consumer\Consumer;
use SymfonyBundles\KafkaBundle\Tests\Integration\TestCase;
use SymfonyBundles\KafkaBundle\Tests\Integration\Fixtures\DependencyInjection\Traits\ConsumerFixture;

class ConsumerTraitTest extends TestCase
{
    public function testAutowiring()
    {
        $fixture = $this->container->get(ConsumerFixture::class);

        $this->assertTrue($fixture->getConsumer() instanceof Consumer);
    }
}
