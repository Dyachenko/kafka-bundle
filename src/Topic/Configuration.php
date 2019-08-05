<?php

namespace SymfonyBundles\KafkaBundle\Topic;

use SymfonyBundles\KafkaBundle\DependencyInjection\KafkaExtension;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class Configuration extends \RdKafka\TopicConf
{
    /**
     * @param ParameterBagInterface $bag
     */
    public function __construct(ParameterBagInterface $bag)
    {
        parent::__construct();

        foreach ($bag->get(KafkaExtension::EXTENSION_ALIAS)['topics']['configuration'] as $name => $value) {
            $this->set($name, $value);
        }
    }
}
