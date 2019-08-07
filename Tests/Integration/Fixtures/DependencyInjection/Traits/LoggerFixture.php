<?php

namespace SymfonyBundles\KafkaBundle\Tests\Integration\Fixtures\DependencyInjection\Traits;

use Psr\Log\LoggerInterface;
use SymfonyBundles\KafkaBundle\DependencyInjection\Traits\LoggerTrait;

class LoggerFixture
{
    use LoggerTrait;

    public function getLogger(): LoggerInterface
    {
        return $this->logger;
    }
}
