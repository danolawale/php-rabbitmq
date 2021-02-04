<?php

namespace Library\Services\RabbitMq\Headers;

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
        $this->_channelService->declareExchange('HeadersExchangeDemo', 'headers');

        //declare three queues and bind the queues to exchange with headers
        $this->_channelService->declareQueue('userQueue');
        $userHeaders = [
            'x-match' => 'all',
            'stream-1' => 'users',
            'stream-2' => 'contact',
            'stream-3' => 'access'
        ];
        $this->_channelService->bindQueueToExchangeWithHeaders('HeadersExchangeDemo', 'userQueue', $userHeaders);

        $this->_channelService->declareQueue('contactQueue');
        $contactHeaders = [
            'x-match' => 'any',
            'stream-2' => 'contact',
            'stream-1' => 'access'
        ];
        $this->_channelService->bindQueueToExchangeWithHeaders('HeadersExchangeDemo', 'contactQueue', $contactHeaders);

        $this->_channelService->declareQueue('accessQueue');
        $accessHeaders = [
            'x-match' => 'any',
            'stream-1' => 'access',
            'stream-2' => 'details',
            'stream-3' => 'user'
        ];
        $this->_channelService->bindQueueToExchangeWithHeaders('HeadersExchangeDemo', 'accessQueue', $accessHeaders);
    }

    public function send(array $data)
    {
        $message = json_encode($data);

        $headers = [
            'stream-1' => 'users',
            'stream-2' => 'contact',
            'stream-3' => 'access'
        ];

        $this->_channelService->publishMessageWithHeaders($message, 'HeadersExchangeDemo', $headers);

        return true;

        //check rabbitmq..message should be published to the userQueue and the contactQueue
    }

    public function logUserDetails()
    {
        $this->_channelService->declareQueue('userQueue');

        $this->_channelService->consumeMessage(function($payload)
        {
            $message = "Exchange Type: Headers; Exchange Name: HeadersExchangeDemo; Queue: userQueue\n";

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
            $message = "Exchange Type: Headers; Exchange Name: HeadersExchangeDemo; Queue: contactQueue\n";

            $message .= "Payload: {$payload->body}\n";

            \Library\Tools\Logger\SimpleLogger::log($message);

            $payload->ack();

        }, 'contactQueue');
    }
}
