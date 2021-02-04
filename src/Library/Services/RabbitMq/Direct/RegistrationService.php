<?php

namespace Library\Services\RabbitMq\Direct;

class RegistrationService
{
    private $_channelService = null;

    public function __construct(\Library\Tools\RabbitMq\AmqpChannelServiceInterface $channelService)
    {
        $this->_channelService = $channelService;
    }

    public function init()
    {
        //declare Exchange
        $this->_channelService->declareExchange('DirectExchangeDemo', 'direct');

        //declare two queues and bind the queues to exchange
        $this->_channelService->declareQueue('userQueue');
        $this->_channelService->bindQueueToExchange('DirectExchangeDemo', 'userQueue', 'user');

        $this->_channelService->declareQueue('contactQueue');
        $this->_channelService->bindQueueToExchange('DirectExchangeDemo', 'contactQueue', 'contact');
    }

    public function send(array $data)
    {
        $message = json_encode($data);

        $this->_channelService->publishMessage($message, 'DirectExchangeDemo', 'user');

        return true;

        //check rabbitmq..message should be published to the userQueue
    }

    public function logUserDetails()
    {
        $this->_channelService->declareQueue('userQueue');

        $this->_channelService->consumeMessage(function($payload)
        {
            $message = "Exchange Type: Direct; Exchange Name: DirectExchangeDemo; Queue: userQueue\n";

            $message .= "Payload: {$payload->body}\n";

            \Library\Tools\Logger\SimpleLogger::log($message);

            $payload->ack();

        }, 'userQueue');
    }

    public function logContactDetails()
    {
        $this->_channelService->declareQueue('contactQueue');

        $this->_channelService->consumeMessage(function($payload)
        {
            $message = "Exchange Type: Direct; Exchange Name: DirectExchangeDemo; Queue: contactQueue\n";

            $message .= "Payload: {$payload->body}\n";

            \Library\Tools\Logger\SimpleLogger::log($message);

            $payload->ack();

        }, 'contactQueue');
    }
}
