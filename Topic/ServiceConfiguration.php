<?php

namespace SymfonyBundles\KafkaBundle\Topic;

class ServiceConfiguration extends \RdKafka\Conf
{
    /**
     * @param array         $configs
     * @param Configuration $topic
     */
    public function __construct(array $configs, Configuration $topic)
    {
        parent::__construct();

        foreach ($configs as $name => $value) {
            $this->set($name, $value);
        }

        $this->setDefaultTopicConf($topic);
    }
}
