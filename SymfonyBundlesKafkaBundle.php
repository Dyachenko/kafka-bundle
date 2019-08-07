<?php

namespace SymfonyBundles\KafkaBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class SymfonyBundlesKafkaBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getContainerExtension()
    {
        return new DependencyInjection\KafkaExtension();
    }
}
