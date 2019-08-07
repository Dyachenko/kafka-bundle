<?php

namespace SymfonyBundles\KafkaBundle\Tests\Integration;

class Kernel
{
    /**
     * @var Fixtures\app\AppKernel
     */
    private static $instance;

    /**
     * @return Fixtures\app\AppKernel
     */
    public static function make()
    {
        static::$instance = new Fixtures\app\AppKernel('test', true);
        static::$instance->boot();

        return static::$instance;
    }
}
