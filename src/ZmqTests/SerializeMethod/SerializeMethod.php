<?php
namespace ZmqTests\SerializeMethod;

interface SerializeMethod
{
    /**
     * Encode
     *
     * @param array $messageArray
     * @return string
     */
    public function encode($messageArray);

    /**
     * Decode
     *
     * @param string $messageString
     * @return array
     */
    public function decode($messageString);
}
