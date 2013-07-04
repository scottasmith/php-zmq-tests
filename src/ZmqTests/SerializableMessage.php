<?php
namespace ZmqTests;

interface SerializableMessage
{
    /**
     * Get the properties to be serialized
     *
     * @return array
     */
    public function getProperties();

    /**
     * Class Invoke
     *
     * Called by the receiver
     */
    public function __invoke();
}

