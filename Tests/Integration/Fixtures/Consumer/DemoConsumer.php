<?php

namespace SymfonyBundles\KafkaBundle\Tests\Integration\Fixtures\Consumer;

use RdKafka\Message;
use SymfonyBundles\KafkaBundle\Command\Consumer;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use SymfonyBundles\KafkaBundle\Tests\Integration\Fixtures\Logger;

class DemoConsumer extends Consumer
{
    public const QUEUE_NAME = 'test_demo';
    public const STOP_MESSAGE = 'stop_test_demo';

    public static $messages = [];

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->logger = new Logger();
    }

    protected function handle(Message $message): void
    {
        if (false !== \strpos($message->payload, static::STOP_MESSAGE)) {
            $this->onStop();
        }

        parent::handle($message);
    }

    protected function onMessage(array $data): void
    {
        static::$messages[] = $data;
    }

    public function getLoggerMessages(): array
    {
        return $this->logger->messages;
    }
}
