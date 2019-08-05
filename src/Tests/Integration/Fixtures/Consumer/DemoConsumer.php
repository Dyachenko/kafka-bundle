<?php

namespace SymfonyBundles\KafkaBundle\Tests\Integration\Fixtures\Consumer;

use RdKafka\Message;
use SymfonyBundles\KafkaBundle\Command\Consumer;

class DemoConsumer extends Consumer
{
    public const QUEUE_NAME = 'test_demo';

    public static $messages = [];

    /**
     * {@inheritdoc}
     */
    protected function onMessage(array $data): void
    {
        static::$messages[] = $data;
    }

    protected function onTimeout(Message $message): void
    {
        throw new \Exception('timeout');
    }

    protected function onEnd(Message $message): void
    {
        throw new \Exception('end');
    }

    protected function onError(Message $message): void
    {
        throw new \Exception($message->errstr());
    }
}
