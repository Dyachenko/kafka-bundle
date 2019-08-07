<?php

namespace SymfonyBundles\KafkaBundle\Tests\Integration\DependencyInjection\Traits;

use SymfonyBundles\KafkaBundle\Producer\Producer;
use SymfonyBundles\KafkaBundle\Tests\Integration\TestCase;
use SymfonyBundles\KafkaBundle\Tests\Integration\Fixtures\DependencyInjection\Traits\ProducerFixture;

class ProducerTraitTest extends TestCase
{
    public function testAutowiring()
    {
        $fixture = $this->container->get(ProducerFixture::class);

        $this->assertTrue($fixture->getProducer() instanceof Producer);
    }
}
