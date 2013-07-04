<?php
namespace ZmqTests\Serializer;

interface Serializer
{
    /**
     * Constructor
     *
     * @param SerializeMethod $method
     */
    public function __construct(SerializeMethod $method);

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
