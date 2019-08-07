<?php

namespace SymfonyBundles\KafkaBundle\Tests\Integration\Consumer;

use RdKafka\Message;
use SymfonyBundles\KafkaBundle\Consumer\Consumer;
use SymfonyBundles\KafkaBundle\Producer\Producer;
use SymfonyBundles\KafkaBundle\Tests\Integration\ConsoleTestCase;
use SymfonyBundles\KafkaBundle\Tests\Integration\Fixtures\Consumer\DemoConsumer;

class DemoConsumerTest extends ConsoleTestCase
{
    public function testConsumerName(): void
    {
        $this->assertSame($this->getConsumerName(), $this->getDemoConsumer()->getName());
    }

    public function testConsume(): void
    {
        $consumer = $this->createConfiguredMock(Consumer::class, []);

        foreach ($this->getMessages() as $index => $message) {
            $consumer->expects($this->at($index))->method('consume')->willReturn($message);
        }

        $this->container->set(Consumer::class, $consumer);

        $this->executeCommand();

        $this->assertSame($this->getExpectedLoggerMessages(), $this->getDemoConsumer()->getLoggerMessages());
    }

    public function testProduceConsume(): void
    {
        $this->container->get(Producer::class)->send(DemoConsumer::QUEUE_NAME, [
            DemoConsumer::STOP_MESSAGE,
        ]);

        $this->expectExceptionMessage(DemoConsumer::STOP_MESSAGE);

        $this->executeCommand(10000);
    }

    private function getMessages(): array
    {
        return [
            $this->createMessage(\RD_KAFKA_RESP_ERR_NO_ERROR, 'no-error'),
            $this->createMessage(\RD_KAFKA_RESP_ERR__TIMED_OUT, 'timed-out'),
            $this->createMessage(\RD_KAFKA_RESP_ERR__PARTITION_EOF, 'partition-eof'),
            $this->createMessage(\RD_KAFKA_RESP_ERR_BROKER_NOT_AVAILABLE, 'broker-not-available'),
            $this->createMessage(\RD_KAFKA_RESP_ERR_NO_ERROR, null),
            $this->createMessage(\RD_KAFKA_RESP_ERR_NO_ERROR, '{x}'),
        ];
    }

    private function getExpectedLoggerMessages(): array
    {
        return [
            'debug' => [
                [
                    'message' => 'Local: Timed out',
                    'context' => [
                        'code' => \RD_KAFKA_RESP_ERR__TIMED_OUT,
                    ],
                ],
                [
                    'message' => 'Broker: No more messages',
                    'context' => [
                        'code' => \RD_KAFKA_RESP_ERR__PARTITION_EOF,
                    ],
                ],
            ],
            'error' => [
                [
                    'message' => 'Broker: Broker not available',
                    'context' => [
                        'code' => \RD_KAFKA_RESP_ERR_BROKER_NOT_AVAILABLE,
                        'payload' => 'broker-not-available',
                    ],
                ],
                [
                    'message' => 'Syntax error',
                    'context' => [
                        'payload' => null,
                    ],
                ],
                [
                    'message' => 'Syntax error',
                    'context' => [
                        'payload' => '{x}',
                    ],
                ],
            ],
        ];
    }

    private function createMessage(int $code, ?string $payload): Message
    {
        $message = new Message();
        $message->err = $code;
        $message->payload = $payload;

        return $message;
    }

    private function getConsumerName(): string
    {
        return 'symfony-bundles:kafka-bundle:tests:integration:fixtures:consumer:demo';
    }

    private function getDemoConsumer(): DemoConsumer
    {
        return $this->container->get(DemoConsumer::class);
    }

    private function executeCommand(int $timeout = 100): void
    {
        $this->createTester($this->getDemoConsumer())->execute(['--timeout' => $timeout]);
    }
}
