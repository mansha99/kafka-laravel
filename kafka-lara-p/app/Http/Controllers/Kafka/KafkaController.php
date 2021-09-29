<?php

namespace App\Http\Controllers\Kafka;

use App\Http\Controllers\Controller;
use App\Services\KafkaMessageSenderService;

use stdClass;

class KafkaController extends Controller
{
    public function index()
    {
        $body=new stdClass();
        $body->text=" Message sent at ".date("Y-m-d h:i:s");
        $result = KafkaMessageSenderService::sendSimpleMessage($body,"motd",0);
        return response()->json(['result' => $result]);
    }
}
