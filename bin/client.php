<?php
require_once __DIR__ . '/../vendor/autoload.php';

use ZmqTests\MessageQueues;
use ZmqTests\MessageQueues\Transport;
use ZmqTests\MessageQueues\Messages\TestMessage;
use ZmqTests\MessageQueues\Serializer\Reflection as Serializer;
use ZmqTests\MessageQueues\SerializeMethod\Json as JsonMethod;

$context = new ZMQContext();

$requester = new ZMQSocket($context, ZMQ::SOCKET_REQ);
$requester->connect('tcp://localhost:5555');

$mqTest = new TestMessage('test data');

$serializer = new Serializer();
$message = $serializer->serialize($mqTest, new JsonMethod);

$requester->send($message);

printf("Reply: %s\n", $requester->recv());

