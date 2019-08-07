<?php

namespace SymfonyBundles\KafkaBundle\Tests\Integration;

use Symfony\Component\Console;

abstract class ConsoleTestCase extends TestCase
{
    /**
     * @var Console\Application
     */
    protected $app;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->app = new Console\Application();
    }

    /**
     * @param Console\Command\Command $command
     *
     * @return Console\Tester\CommandTester
     */
    protected function createTester(Console\Command\Command $command): Console\Tester\CommandTester
    {
        $this->app->add($command);

        return new Console\Tester\CommandTester($this->app->find($command->getName()));
    }
}
