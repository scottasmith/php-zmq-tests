<?php
namespace ZmqTests\MessageQueues\SerializeMethod;

class Json implements SerializeMethod
{
    /**
     * Encode
     *
     * @param array $messageArray
     * @return string
     */
    public function encode($messageArray)
    {
        return json_encode($messageArray);
    }

    /**
     * Decode
     *
     * @param string $messageString
     * @return array
     */
    public function decode($messageString)
    {
        return json_decode($messageString, true);
    }
}
