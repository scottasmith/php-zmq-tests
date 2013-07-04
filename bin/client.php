<?php
require_once __DIR__ . '/../vendor/autoload.php';

use ZmqTests;
use ZmqTests\Transport;
use ZmqTests\Messages\TestMessage;
use ZmqTests\Serializer\Reflection as Serializer;
use ZmqTests\SerializeMethod\Json as JsonMethod;

$context = new ZMQContext();

$requester = new ZMQSocket($context, ZMQ::SOCKET_REQ);
$requester->connect('tcp://localhost:5555');

$mqTest = new TestMessage('test data');

$serializer = new Serializer(new JsonMethod);
$message = $serializer->serialize($mqTest);

$requester->send($message);

printf("Reply: %s\n", $requester->recv());

