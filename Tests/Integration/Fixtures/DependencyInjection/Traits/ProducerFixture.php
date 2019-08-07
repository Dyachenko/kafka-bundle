<?php

namespace SymfonyBundles\KafkaBundle\Tests\Integration\Fixtures\DependencyInjection\Traits;

use SymfonyBundles\KafkaBundle\Producer\Producer;
use SymfonyBundles\KafkaBundle\DependencyInjection\Traits\ProducerTrait;

class ProducerFixture
{
    use ProducerTrait;

    public function getProducer(): Producer
    {
        return $this->producer;
    }
}
