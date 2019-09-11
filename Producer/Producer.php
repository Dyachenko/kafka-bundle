<?php

namespace SymfonyBundles\KafkaBundle\Producer;

class Producer
{
    /**
     * @var \RdKafka\Producer
     */
    protected $client;

    /**
     * @var array|\RdKafka\ProducerTopic[]
     */
    protected $topics = [];

    /**
     * @var Configuration
     */
    protected $configuration;

    /**
     * {@inheritdoc}
     */
    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * @return \RdKafka\Producer
     */
    public function getClient(): \RdKafka\Producer
    {
        if (null === $this->client) {
            $this->client = new \RdKafka\Producer($this->configuration);
        }

        return $this->client;
    }

    /**
     * @param string $name
     *
     * @return \RdKafka\ProducerTopic
     */
    public function getTopic(string $name): \RdKafka\ProducerTopic
    {
        if (false === isset($this->topics[$name])) {
            $this->topics[$name] = $this->getClient()->newTopic($name);
        }

        return $this->topics[$name];
    }

    /**
     * @param string $name
     * @param array  $data
     */
    public function send(string $name, array $data): void
    {
        $this->getTopic($name)->produce(\RD_KAFKA_PARTITION_UA, 0, \json_encode($data));
    }
}
