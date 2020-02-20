<?php

namespace SymfonyBundles\KafkaBundle\Command;

use Exception;
use JsonException;
use RdKafka\Message;
use Symfony\Component\Console;
use SymfonyBundles\KafkaBundle\DependencyInjection\Traits\{ConsumerTrait, LoggerTrait};

abstract class Consumer extends Console\Command\Command
{
    use ConsumerTrait, LoggerTrait;

    /**
     * @var string
     */
    public const QUEUE_NAME = 'topic_name';

    /**
     * @var bool
     */
    private $isRunning = true;

    /**
     * {@inheritdoc}
     */
    final public function __construct(string $name = null)
    {
        if (null === $name) {
            $name = (string) \preg_replace('#consumer$#i', '', static::class);
            $name = \mb_strtolower((string) \preg_replace('#([a-z])([A-Z])#', '$1-$2', \strtr($name, ['\\' => ':'])));
        }

        parent::__construct($name);
    }

    /**
     * {@inheritdoc}
     */
    final protected function configure()
    {
        $this->addOption('timeout', 't', Console\Input\InputOption::VALUE_REQUIRED, 'Consume timeout', 10000);
    }

    /**
     * {@inheritdoc}
     */
    final public function execute(Console\Input\InputInterface $input, Console\Output\OutputInterface $output)
    {
        \pcntl_async_signals(true);
        \pcntl_signal(\SIGTERM, [$this, 'onStop']);

        $this->onInitialize();

        $this->consumer->subscribe([static::QUEUE_NAME]);

        while ($this->isRunning && $message = $this->consumer->consume($input->getOption('timeout'))) {
            $this->handle($message);
        }
    }

    /**
     * @param Message $message
     */
    protected function handle(Message $message): void
    {
        switch ($message->err) {
            case \RD_KAFKA_RESP_ERR_NO_ERROR:
                try {
                    $this->onMessage($this->getPayload($message));
                } catch (Exception $exception) {
                    $this->onException($message, $exception);
                }
                break;
            case \RD_KAFKA_RESP_ERR__PARTITION_EOF:
                $this->onEnd($message);
                break;
            case \RD_KAFKA_RESP_ERR__TIMED_OUT:
                $this->onTimeout($message);
                break;
            default:
                $this->onError($message);
                break;
        }
    }

    /**
     * Consumer initializing method.
     */
    protected function onInitialize(): void
    {
    }

    /**
     * @param array $data
     */
    abstract protected function onMessage(array $data): void;

    /**
     * @param Message   $message
     * @param Exception $exception
     */
    protected function onException(Message $message, Exception $exception): void
    {
        $this->logger->error($exception->getMessage(), ['payload' => $message->payload]);
    }

    /**
     * @param Message $message
     */
    protected function onEnd(Message $message): void
    {
        $this->logger->debug($message->errstr(), ['code' => $message->err]);
    }

    /**
     * @param Message $message
     */
    protected function onTimeout(Message $message): void
    {
        $this->logger->debug($message->errstr(), ['code' => $message->err]);
    }

    /**
     * @param Message $message
     */
    protected function onError(Message $message): void
    {
        $this->logger->error($message->errstr(), ['code' => $message->err, 'payload' => $message->payload]);
    }

    /**
     * Consumer stopping handler.
     */
    protected function onStop(): void
    {
        $this->isRunning = false;

        $this->logger->debug('SIGTERM');
    }

    /**
     * @param Message $message
     *
     * @return array
     *
     * @throws Exception|JsonException
     */
    protected function getPayload(Message $message): array
    {
        return \json_decode($message->payload, true, 512, \JSON_THROW_ON_ERROR);
    }
}
