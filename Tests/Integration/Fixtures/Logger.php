<?php

namespace SymfonyBundles\KafkaBundle\Tests\Integration\Fixtures;

use Psr\Log\LoggerInterface;

class Logger implements LoggerInterface
{
    public $messages = [];

    public function emergency($message, array $context = [])
    {
        $this->log(__FUNCTION__, $message, $context);
    }

    public function alert($message, array $context = [])
    {
        $this->log(__FUNCTION__, $message, $context);
    }

    public function critical($message, array $context = [])
    {
        $this->log(__FUNCTION__, $message, $context);
    }

    public function error($message, array $context = [])
    {
        $this->log(__FUNCTION__, $message, $context);
    }

    public function warning($message, array $context = [])
    {
        $this->log(__FUNCTION__, $message, $context);
    }

    public function notice($message, array $context = [])
    {
        $this->log(__FUNCTION__, $message, $context);
    }

    public function info($message, array $context = [])
    {
        $this->log(__FUNCTION__, $message, $context);
    }

    public function debug($message, array $context = [])
    {
        $this->log(__FUNCTION__, $message, $context);
    }

    public function log($level, $message, array $context = [])
    {
        $this->messages[$level][] = ['message' => $message, 'context' => $context];
    }
}
