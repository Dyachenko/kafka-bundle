<?php

namespace SymfonyBundles\KafkaBundle\DependencyInjection\Traits;

use SymfonyBundles\KafkaBundle\Producer\Producer;

trait ProducerTrait
{
    /**
     * @var Producer
     */
    protected $producer;

    /**
     * @required
     *
     * @param Producer $producer
     */
    public function setProducer(Producer $producer): void
    {
        $this->producer = $producer;
    }
}
