<?php
require_once __DIR__ . '/../vendor/autoload.php';

use ZmqTests as mq;
use ZmqTests\Transport;
use ZmqTests\Serializer\Reflection as Serializer;
use ZmqTests\SerializeMethod\Json as JsonMethod;

$responder = new Transport\ResponderServer('*', 5555);

while (true) {
    $request = $responder->recv();

    $serializer = new Serializer(new JsonMethod);
    $message = $serializer->unserialize($request);

    echo sprintf("Received message with class: %s\n", get_class($message));
 
    $responder->send($message());
}
