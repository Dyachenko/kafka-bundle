<?php

namespace SymfonyBundles\KafkaBundle\DependencyInjection\Traits;

use SymfonyBundles\KafkaBundle\Consumer\Consumer;

trait ConsumerTrait
{
    /**
     * @var Consumer
     */
    protected $consumer;

    /**
     * @required
     *
     * @param Consumer $consumer
     */
    public function setConsumer(Consumer $consumer): void
    {
        $this->consumer = $consumer;
    }
}
