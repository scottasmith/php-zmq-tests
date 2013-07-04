<?php
namespace ZmqTests\MessageQueues\Exception;

class MessageUnserializeException extends \Exception
{
    // @var string
    protected $serializedMessage;

    /**
     * Constructor
     *
     * @param string $error
     * @param string $serizalizedMessage
     */
    public function __construct($error, $serializedMessage)
    {
        parent::__construct($error);

        $this->serializedMessage = $serializedMessage;
    }

    /**
     * Get serialized message
     *
     * @return string
     */
    public function getSerializedMessage()
    {
        return $this->serializedMessage;
    }
}
