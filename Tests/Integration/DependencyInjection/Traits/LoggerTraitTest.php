<?php

namespace SymfonyBundles\KafkaBundle\Tests\Integration\DependencyInjection\Traits;

use Psr\Log\LoggerInterface;
use SymfonyBundles\KafkaBundle\Tests\Integration\TestCase;
use SymfonyBundles\KafkaBundle\Tests\Integration\Fixtures\DependencyInjection\Traits\LoggerFixture;

class LoggerTraitTest extends TestCase
{
    public function testAutowiring()
    {
        $fixture = $this->container->get(LoggerFixture::class);

        $this->assertTrue($fixture->getLogger() instanceof LoggerInterface);
    }
}
