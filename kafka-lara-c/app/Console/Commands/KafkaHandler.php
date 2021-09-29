<?php

namespace App\Console\Commands;

use App\Services\KafkaMessageConsumerService;
use GuzzleHttp\Psr7\Message;
use Illuminate\Console\Command;

class KafkaHandler{
    public function __invoke(Message $message)
    {
        echo '--------------------------';
    }
}