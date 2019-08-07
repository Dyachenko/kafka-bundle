<?php

namespace SymfonyBundles\KafkaBundle\Topic;

class Configuration extends \RdKafka\TopicConf
{
    /**
     * @param array $configs
     */
    public function __construct(array $configs)
    {
        parent::__construct();

        foreach ($configs as $name => $value) {
            $this->set($name, $value);
        }
    }
}
