<?php

namespace SymfonyBundles\KafkaBundle\Producer;

class Producer extends \RdKafka\Producer
{
    /**
     * @var array|\RdKafka\ProducerTopic[]
     */
    protected $topics = [];

    /**
     * {@inheritdoc}
     */
    public function __construct(Configuration $configuration)
    {
        parent::__construct($configuration);
    }

    /**
     * @param string $name
     * @param array  $data
     */
    public function send(string $name, array $data): void
    {
        if (false === isset($this->topics[$name])) {
            $this->topics[$name] = $this->newTopic($name);
        }

        $this->topics[$name]->produce(\RD_KAFKA_PARTITION_UA, 0, \json_encode($data));
    }
}
