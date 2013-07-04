<?php
namespace ZmqTests\MessageQueues\Messages;

use ZmqTests\MessageQueues\SerializableMessage;

class TestMessage implements SerializableMessage
{
    // @var string
    private $someData;

    public function __construct($someData)
    {
        $this->someData = $someData;
    }

    /**
     * Get properties to be serialize
     *
     * @return array
     */
    public function getProperties()
    {
        return array('someData');
    }

    public function __invoke()
    {
        return sprintf("%s invoked\n", get_class($this));
    }
}

