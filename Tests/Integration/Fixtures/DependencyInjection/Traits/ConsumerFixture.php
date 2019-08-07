<?php

namespace SymfonyBundles\KafkaBundle\Tests\Integration\Fixtures\DependencyInjection\Traits;

use SymfonyBundles\KafkaBundle\Consumer\Consumer;
use SymfonyBundles\KafkaBundle\DependencyInjection\Traits\ConsumerTrait;

class ConsumerFixture
{
    use ConsumerTrait;

    public function getConsumer(): Consumer
    {
        return $this->consumer;
    }
}
