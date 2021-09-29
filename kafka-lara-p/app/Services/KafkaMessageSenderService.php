<?php

namespace App\Services;

class KafkaMessageSenderService
{
    public static function sendSimpleMessage($body, $topic, $broker)
    {
        $conf = new \RdKafka\Conf();
        // $conf->set('metadata.broker.list', env('KAFKA_BROKERS', '127.0.0.1'));
        $conf->set('metadata.broker.list', env('KAFKA_BROKERS', '127.0.0.1'));
        
        $conf->set('compression.type', 'snappy');
        //$conf->set('log_level', LOG_DEBUG);
        //$conf->set('debug', 'all');
        $producer = new \RdKafka\Producer($conf);
        $producer->addBrokers($broker);
        $topic = $producer->newTopic($topic);
        //$topic = $producer->newTopic($topic);
        $topic->produce(RD_KAFKA_PARTITION_UA, 0, $body);
        $producer->poll(0);
        for ($flushRetries = 0; $flushRetries < 10; $flushRetries++) {
            $response = $producer->flush(10000);
            if (RD_KAFKA_RESP_ERR_NO_ERROR === $response) {
                break;
            }
        }
        return $response == 0 ? true : false;
    }
}
