<?php

namespace Library\Services\RabbitMq\Topic;

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
        $this->_channelService->declareExchange('TopicExchangeDemo', 'topic');

        //declare two queues and bind the queues to exchange
        $this->_channelService->declareQueue('userQueue');
        $this->_channelService->bindQueueToExchange('TopicExchangeDemo', 'userQueue', '*.user.#');

        $this->_channelService->declareQueue('contactQueue');
        $this->_channelService->bindQueueToExchange('TopicExchangeDemo', 'contactQueue', '#.contact.*');

        $this->_channelService->declareQueue('accessQueue');
        $this->_channelService->bindQueueToExchange('TopicExchangeDemo', 'accessQueue', '*.*.contact');
    }

    public function send(array $data)
    {
        $message = json_encode($data);

        $this->_channelService->publishMessage($message, 'TopicExchangeDemo', 'user.name.tile.contact.access');

        return true;

        //check rabbitmq..message should be published to only the contactQueue
    }

    public function logContactDetails()
    {
        $this->_channelService->declareQueue('contactQueue');

        $this->_channelService->consumeMessage(function($payload)
        {
            $message = "Exchange Type: Topic; Exchange Name: TopicExchangeDemo; Queue: contactQueue\n";

            $message .= "Payload: {$payload->body}\n";

            \Library\Tools\Logger\SimpleLogger::log($message);

        }, 'contactQueue');
    }
}
