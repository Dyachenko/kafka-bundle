<?php

namespace SymfonyBundles\KafkaBundle\Tests\Integration\Consumer;

use SymfonyBundles\KafkaBundle\Producer\Producer;
use SymfonyBundles\KafkaBundle\Tests\Integration\ConsoleTestCase;
use SymfonyBundles\KafkaBundle\Tests\Integration\Fixtures\Consumer\DemoConsumer;

class DemoConsumerTest extends ConsoleTestCase
{
    public function testConsumerName()
    {
        $this->assertSame($this->getConsumerName(), $this->getConsumer()->getName());
    }

    public function testOnTimeout()
    {
        $this->expectExceptionMessage('timeout');
        $this->executeCommand(100);
    }

    public function testOnMessage()
    {
        $messages = [
            ['name' => null],
            ['count' => 123],
            ['hello' => 'its me'],
        ];

        foreach ($messages as $message) {
            $this->getProducer()->send(DemoConsumer::QUEUE_NAME, $message);
        }

        try {
            $this->executeCommand(10000);
        } catch (\Exception $exception) {
            $this->assertSame('timeout', $exception->getMessage());
        }

        $this->assertSame($messages, DemoConsumer::$messages);
    }

    protected function getConsumerName(): string
    {
        return 'symfony-bundles:kafka-bundle:tests:integration:fixtures:consumer:demo';
    }

    protected function getConsumer(): DemoConsumer
    {
        return $this->container->get(DemoConsumer::class);
    }

    protected function getProducer(): Producer
    {
        return $this->container->get(Producer::class);
    }

    protected function executeCommand(int $timeout = 100): void
    {
        $this->createTester($this->getConsumer())->execute(['--timeout' => $timeout]);
    }
}
