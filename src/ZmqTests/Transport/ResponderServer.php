<?php
namespace ZmqTests\Transport;

class ResponderServer
{
    // @var \ZQMContext
    private $context;

    // @var \ZQMSocket
    private $socket;

    public function __construct($host, $port)
    {
        $this->init($host, $port);
    }

    private function init($host, $port, $bind = 'tcp')
    {
        if (!is_string($host)) {
            throw new \Exception('host(' . var_export($host, 1) . ') is not a string');
        }

        if (!filter_var($port, FILTER_VALIDATE_INT)) {
            throw new \Exception('port(' . var_export($port, 1). ') is not an integer');
        }

        $this->context = new \ZMQContext();

        $bindStr = "{$bind}://{$host}:{$port}";

        $this->socket = new \ZMQSocket($this->context, \ZMQ::SOCKET_REP);
        $this->socket->bind($bindStr);
    }

    /**
     *  Receive message from socket
     *  Creates a new message and returns it
     *  Blocks on recv if socket is not ready for input
     *
     * @throws Exception if no socket present
     * @return string
     */
    public function recv()
    {
        if (!isset($this->socket)) {
            throw new \Exception("No socket supplied");
        }

        return $this->socket->recv();
    }

    /**
     *  Send message to socket
     *
     * @throws Exception if no socket present
     * @param string
     */
    public function send($msg)
    {
        if (!isset($this->socket)) {
            throw new \Exception("No socket supplied");
        }

        $this->socket->send($msg);
    }
}

