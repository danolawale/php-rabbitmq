<?php

namespace Tests\IntegrationTests\Library\Services\RabbitMq\Basic;

class RegistrationServiceTest
    extends \Tests\AbstractTestProxyService
{
    public function setUp(): void
    {
        $this->_channel = $this->createMock(\Library\Tools\RabbitMq\AmqpChannelServiceInterface::class);

        $this->_channel
            ->expects($this->once())
            ->method('declareQueue')
            ->with($this->equalTo(\Library\Services\RabbitMq\Basic\RegistrationService::class));

        $this->_service = new \Library\Services\RabbitMq\Basic\RegistrationService($this->_channel);
    }

    public function test_message_publish()
    {
        $data = [
            'firstname' => 'Tester',
            'lastname' => 'test',
            'email' => 'test@test.com'
        ];
    
        $this->_channel
            ->expects($this->once())
            ->method('publishMessage')
            ->with($this->equalTo(json_encode($data)));

        $this->_service->sendData($data);
    }

    public function test_message_publish_multiple()
    {
        $data = [
            'user' => [
                'firstname' => 'Tester',
                'lastname' => 'test',
                'email' => 'test@test.com'
            ],
            'address' => [
                'address1' => 'address 1',
                'address2' => 'address 2',
                'post_code' => '123',
                'email' => 'test@test.com'
            ]
        ];

        $this->_channel
            ->expects($this->exactly(2))
            ->method('publishMessage')
            ->withConsecutive(
                [$this->equalTo(json_encode($data['user']))],
                [$this->equalTo(json_encode($data['address']))]
            );

        $this->_service->sendMultipleMessages($data);
    }

    public function test_create_user()
    {
        $this->_channel
            ->expects($this->once())
            ->method('consumeMessage');

            $this->_service->createUser();

    }
}