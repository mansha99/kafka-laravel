<?php

namespace App\Console\Commands;

use App\Services\KafkaMessageSenderService;
use Illuminate\Console\Command;

class SendKafkaMessageCommand extends Command
{

    protected $signature = 'kafka:send {message} {topic} {cluster}';
    protected $description = 'Send a  {message} to Kafka topic {topic} with cluster-id {cluster}';
    private $kafkaMessageSenderService;
    public function __construct(KafkaMessageSenderService $kafkaMessageSenderService)
    {
        parent::__construct();
        $this->kafkaMessageSenderService= $kafkaMessageSenderService;
    }
    public function handle()
    {
        $message = $this->argument('message');
        $topic = $this->argument('topic');
        $cluster = $this->argument('cluster');
        $result = $this->kafkaMessageSenderService->sendSimpleMessage($message, $topic, $cluster);
        echo PHP_EOL . 'Response : ' . PHP_EOL;
        echo PHP_EOL . json_encode($result) . PHP_EOL;
    }
}
