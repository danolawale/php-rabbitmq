<?php

namespace Library\Tools\RabbitMq;

interface AmqpChannelServiceInterface
{
    public function declareExchange(string $name, string $type);
    public function getChannel();
    public function declareQueue(string $queueName);
    public function publishMessage(string $message, string $exchange = '', string $routingKey = '');
    public function declareMultipleQueues(array $queues);
    public function consumeMessage($callback, string $queueName);
}