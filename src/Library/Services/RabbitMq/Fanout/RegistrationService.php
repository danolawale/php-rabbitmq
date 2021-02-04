<?php

namespace Library\Services\RabbitMq\Fanout;

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
        $this->_channelService->declareExchange('FanoutExchangeDemo', 'fanout');

        //declare two queues and bind the queues to exchange
        $this->_channelService->declareQueue('fanout-userQueue');
        $this->_channelService->bindQueueToExchange('FanoutExchangeDemo', 'fanout-userQueue');

        $this->_channelService->declareQueue('fanout-contactQueue');
        $this->_channelService->bindQueueToExchange('FanoutExchangeDemo', 'fanout-contactQueue');

        //this should not receive the message as it is not bound to the fanout exchange
        $this->_channelService->declareQueue('nothingQueue');
    }

    public function send(array $data)
    {
        $message = json_encode($data);

        $this->_channelService->publishMessage($message, 'FanoutExchangeDemo');

        return true;

        //check rabbitmq..message should be published to all the bound queues
    }

    public function logUserDetails()
    {
        $this->_channelService->declareQueue('fanout-userQueue');

        $this->_channelService->consumeMessage(function($payload)
        {
            $message = "Exchange Type: Fanout; Exchange Name: FanoutExchangeDemo; Queue: fanout-userQueue\n";

            $message .= "Payload: {$payload->body}\n";

            \Library\Tools\Logger\SimpleLogger::log($message);

        }, 'fanout-userQueue');
    }

    public function logContactDetails()
    {
        $this->_channelService->declareQueue('fanout-contactQueue');

        $this->_channelService->consumeMessage(function($payload)
        {
            $message = "Exchange Type: Fanout; Exchange Name: FanoutExchangeDemo; Queue: fanout-contactQueue\n";

            $message .= "Payload: {$payload->body}\n";

            \Library\Tools\Logger\SimpleLogger::log($message);

        }, 'fanout-contactQueue');
    }
}
