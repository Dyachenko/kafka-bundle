<?php

namespace SymfonyBundles\KafkaBundle\Consumer;

class Consumer extends \RdKafka\KafkaConsumer
{
    /**
     * {@inheritdoc}
     */
    public function __construct(Configuration $configuration)
    {
        parent::__construct($configuration);
    }

    /**
     * {@inheritdoc}
     */
    public function consume($timeout = 10000)
    {
        return parent::consume($timeout);
    }
}
