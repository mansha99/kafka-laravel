<?php

namespace App\Console\Commands;

use App\Services\KafkaMessageConsumerService;

use Illuminate\Console\Command;

class ReceiveKafkaMessageCommand extends Command
{

    protected $signature = 'kafka:rcv {topic} {broker}';
    protected $description = 'Receive a  messages at Kafka topic {topic} with broker-id {broker}';
    private $kafkaMessageConsumerService;
    public function __construct(KafkaMessageConsumerService $kafkaMessageConsumerService)
    {
        parent::__construct();
        $this->kafkaMessageConsumerService= $kafkaMessageConsumerService;
    }
    public function handle()
    {
        $topic = $this->argument('topic');
        $broker = $this->argument('broker');
        $this->kafkaMessageConsumerService->startListening($topic, $broker);
    }
}
