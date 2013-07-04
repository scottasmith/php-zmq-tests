<?php
namespace ZmqTests\MessageQueues\Serializer;

interface Serializer
{
    /**
     * Serialize Message
     *
     * @param SerializableMessage $message
     * @return string
     */
    public function serialize(SerializableMessage $message);

    /**
     * Unserialize Message
     *
     * @param string
     * @return SerializableMessage
     */
    public function unserialize($messageString);
}
