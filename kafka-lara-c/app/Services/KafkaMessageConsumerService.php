<?php

namespace App\Services;

use App\Console\Commands\KafkaHandler;

class KafkaMessageConsumerService
{
    public function __construct()
    {
    }
    public function startListening($topic, $broker)
    {
        $conf = new \RdKafka\Conf();
        $conf->set('metadata.broker.list', env('KAFKA_BROKERS', '127.0.0.1'));
        // $conf->set('log_level', (string) LOG_DEBUG);
        // $conf->set('debug', 'all');
        $rk = new \RdKafka\Consumer($conf);
        $rk->addBrokers($broker);
        
        $topic = $rk->newTopic($topic);

        // The first argument is the partition to consume from.
        // The second argument is the offset at which to start consumption. Valid values
        // are: RD_KAFKA_OFFSET_BEGINNING, RD_KAFKA_OFFSET_END, RD_KAFKA_OFFSET_STORED.
        $topic->consumeStart(0, RD_KAFKA_OFFSET_BEGINNING);
        while (true) {
            // The first argument is the partition (again).
            // The second argument is the timeout.
            $msg = $topic->consume(0, 1000);
            if (null === $msg || $msg->err === RD_KAFKA_RESP_ERR__PARTITION_EOF) {
                // Constant check required by librdkafka 0.11.6. Newer librdkafka versions will return NULL instead.
                continue;
            } elseif ($msg->err) {
                echo $msg->errstr(), "\n";
                break;
            } else {
                echo $msg->payload, "\n";
            }
        }

        //      $conf = new \RdKafka\Conf();
        //    // $conf->set('metadata.broker.list', env('KAFKA_BROKERS', '127.0.0.1'));
        //     $conf->set('compression.type', 'snappy');
        //     //$conf->set('log_level', LOG_DEBUG);
        //     //$conf->set('debug', 'all');
        //     $producer = new \RdKafka\Producer($conf);
        //     $producer->addBrokers($broker);
        //     $topic = $producer->newTopic($topic);
        //     //$topic = $producer->newTopic($topic);
        //     $topic->produce(RD_KAFKA_PARTITION_UA, 0, $body);
        //     $producer->poll(0);
        //     for ($flushRetries = 0; $flushRetries < 10; $flushRetries++) {
        //         $response = $producer->flush(10000);
        //         if (RD_KAFKA_RESP_ERR_NO_ERROR === $response) {
        //             break;
        //         }
        //     }
        //     return $response == 0 ? true : false;
    }
}
