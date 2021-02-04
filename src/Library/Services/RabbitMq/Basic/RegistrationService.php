<?php

namespace Library\Services\RabbitMq\Basic;

class RegistrationService
{
    private $_channelService = null;

    public function __construct(\Library\Tools\RabbitMq\AmqpChannelServiceInterface $channelService)
    {
        $this->_channelService = $channelService;
    }

    public function sendData(array $data)
    {
        $this->_channelService->declareQueue(__CLASS__ );

        $message = json_encode($data);

        $this->_channelService->publishMessage($message, '', __CLASS__);

        return true;
    }

    public function createUser()
    {
        $this->_channelService->declareQueue(__CLASS__ );

        $this->_channelService->consumeMessage(function($message)
        {
            $userData = json_decode($message->body, true);

            return \Library\Model\Repository\UserAccountRepository::createUser($userData);
        }, __CLASS__);
    }

    public function createUserContact()
    {
        $this->_channelService->declareQueue(__CLASS__ );

        $this->_channelService->consumeMessage(function($message)
        {
            $userContactData = json_decode($message->body, true);

            sleep(3);

            return \Library\Model\Repository\UserContactDetailsRepository::createUserContact($userContactData);
        }, __CLASS__);
    }

    public function sendMultipleMessages(array $data)
    {
        $this->_channelService->declareQueue(__CLASS__ );

        $messages = [$data['user'], $data['address'] ];

        foreach($messages as $message)
        {
            $this->_channelService->publishMessage(json_encode($message), '', __CLASS__);
        }

        return true;
    }

    public function retrieveMessages()
    {
        $this->_channelService->declareQueue(__CLASS__ );

        $this->_channelService->consumeMessage(function($message)
        {
            echo 'Message Received is ' . $message->body . '\n';

            $message->ack();
        },__CLASS__);
    }
}
