<?php
require_once __DIR__ . '/../vendor/autoload.php';

use ZmqTests\MessageQueues as mq;
use ZmqTests\MessageQueues\Transport;
use ZmqTests\MessageQueues\Serializer\Reflection as Serializer;
use ZmqTests\MessageQueues\SerializeMethod\Json as JsonMethod;

$responder = new Transport\ResponderServer('*', 5555);

while (true) {
    $request = $responder->recv();

    $serializer = new Serializer();
    $message = $serializer->unserialize($request, new JsonMethod);

    echo sprintf("Received message with class: %s\n", get_class($message));
 
    $responder->send($message());
}
