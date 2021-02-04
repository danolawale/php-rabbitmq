<?php require __DIR__.'/../../../vendor/autoload.php';

//this is a listener
$rabbitConnection = Loader::getInstance(\Library\Tools\RabbitMq\AmqpStreamConnectionService::class);

$registrationService = new \Library\Services\RabbitMq\Direct\RegistrationService(
    new \Library\Tools\RabbitMq\AmqpChannelService($rabbitConnection));

$registrationService->logContactDetails();