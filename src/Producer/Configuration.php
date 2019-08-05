<?php

namespace SymfonyBundles\KafkaBundle\Producer;

use SymfonyBundles\KafkaBundle\Topic;
use SymfonyBundles\KafkaBundle\DependencyInjection\KafkaExtension;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class Configuration extends \RdKafka\Conf
{
    /**
     * @param ParameterBagInterface $bag
     * @param Topic\Configuration   $topic
     */
    public function __construct(ParameterBagInterface $bag, Topic\Configuration $topic)
    {
        parent::__construct();

        foreach ($bag->get(KafkaExtension::EXTENSION_ALIAS)['producers']['configuration'] as $name => $value) {
            $this->set($name, $value);
        }

        $this->setDefaultTopicConf($topic);
    }
}
