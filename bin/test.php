<?php
require_once __DIR__ . '/../vendor/autoload.php';

use ZmqTests;
use ZmqTests\Messages\TestMessage;
use ZmqTests\Serializer\Reflection as Serializer;
use ZmqTests\SerializeMethod\Json as JsonMethod;

$messageInstance = new TestMessage('test data');

$serializer = new Serializer(new JsonMethod);
$message = $serializer->serialize($messageInstance);

$messageInstance2 = $serializer->unserialize($messageInstance);

echo "Message Instance 1:\n\n";
var_dump($messageInstance);

echo "Message Instance 2:\n\n";
var_dump($messageInstance2);
