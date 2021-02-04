<?php

namespace Library\Tools\RabbitMq;

use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Exception\AMQPProtocolChannelException;
use PhpAmqpLib\Wire\AMQPTable;

final class AmqpChannelService
    implements AmqpChannelServiceInterface
{
    private AmqpStreamConnectionService $_amqp;
    private $_channel = null;
    private array $_queues;
    private string $_exchange;

    public function __construct(AmqpStreamConnectionService $rabbitConnection)
    {
        $this->_amqp = $rabbitConnection;
    }

    public function getChannel()
    {
        return $this->_channel ??= $this->_amqp->getConnection()->channel();
    }

    public function declareExchange(string $name, string $type)
    {
        if(!in_array($type, ['direct', 'fanout', 'topic', 'headers']))
        {
            throw new \Exception("Invalid exchange type {$type}");
        }

        try
        {
            $this->getChannel()->exchange_declare($name, $type, false, false, false);

            $this->_exchange = $name;
        }
        catch(AMQPProtocolChannelException $e)
        {
            throw new AMQPProtocolChannelException("Error: ". $e->getMessage());
        }
    }

    public function declareQueue(string $queueName)
    {
        try
        {
            $this->getChannel()->queue_declare($queueName, false, true);

            $this->_queues[$queueName]['name'] = $queueName;
        }
        catch(AMQPProtocolChannelException $e)
        {
            throw new AMQPProtocolChannelException("Error: ". $e->getMessage());
        }
    }

    public function declareMultipleQueues(array $queues)
    {
        foreach($queues as $name)
        {
            $this->declareQueue($name);
        }
    }

    public function bindQueueToExchange(string $exchange, string $queue, string $routingKey = '')
    {
        try
        {
            $this->getChannel()->queue_bind($queue, $exchange, $routingKey);
        }
        catch(AMQPProtocolChannelException $e)
        {
            throw new AMQPProtocolChannelException("Error: ". $e->getMessage());
        }
    }

    public function bindQueueToExchangeWithHeaders(string $exchange, string $queue, array $headers)
    {
        try
        {
            $headers = new AMQPTable($headers);

            $this->getChannel()->queue_bind($queue, $exchange, '', false, $headers);
        }
        catch(AMQPProtocolChannelException $e)
        {
            throw new AMQPProtocolChannelException("Error: ". $e->getMessage());
        }
    }

    public function publishMessage(string $message, string $exchange = '', string $routingKey = '')
    {
        try
        {
            $msg = new AMQPMessage($message, [ 'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT ]);

            $this->_channel->basic_publish($msg, $exchange, $routingKey);
        }
        catch(AMQPProtocolChannelException $e)
        {
            throw new AMQPProtocolChannelException("Error: ". $e->getMessage());
        }
    }

    public function publishMessageWithHeaders(string $mesage, string $exchange, array $headers)
    {
        try
        {
            $headers = new AMQPTable($headers);

            $msg = new AMQPMessage($message, [ 'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT ]);

            $msg->set('application_headers', $headers);

            $this->_channel->basic_publish($msg, $exchange, '');
        }
        catch(AMQPProtocolChannelException $e)
        {
            throw new AMQPProtocolChannelException("Error: ". $e->getMessage());
        }
    }

    public function consumeMessage($callback, string $queueName)
    {
        $this->_channel ??= $this->getChannel();

        $this->_channel->basic_consume($queueName, '', false, true, false, false, $callback);

        while($this->_channel->is_consuming())
        {
            $this->_channel->wait();
        }
    }

    public function __destruct()
    {
        $this->_channel->close();

        $this->_amqp->close();
    }
}