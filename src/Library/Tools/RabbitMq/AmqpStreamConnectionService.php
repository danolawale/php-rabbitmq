<?php

namespace Library\Tools\RabbitMq;

use PhpAmqpLib\Connection\AMQPStreamConnection;

final class AmqpStreamConnectionService
{
    private string $rabbitHost;
    private string $rabbitPort;
    private string $rabbitUser;
    private string $rabbitPass;

    private static $_connection = null;

    public function __construct(
        string $rabbitHost, string $rabbitPort, string $rabbitUser, string $rabbitPass)
    {
        $this->_rabbitHost = $rabbitHost;
        $this->_rabbitPort = $rabbitPort;
        $this->_rabbitUser = $rabbitUser;
        $this->_rabbitPass = $rabbitPass;
    }

    public function getConnection()
    {
        try
        {
            if(!self::$_connection)
            {
                self::$_connection = new AMQPStreamConnection($this->_rabbitHost, $this->_rabbitPort, $this->_rabbitUser, $this->_rabbitPass);
            }

            return self::$_connection;
        }
        catch(\Exception $e)
        {
            echo "Failed to connect to AMQP. \n";
            throw new \Exception($e->getMessage(), (int)$e->getCode());
        }
    }

    public function close()
    {
        if(self::$_connection)
        {
            self::$_connection->close();
        }
    }
}