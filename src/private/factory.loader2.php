<?php

return [
    'preload' => [
        \Library\Model\Adapter\DbAdapterInterface::class => '/Library/Model/Adapter/MysqlPdoAdapter.php',
        \Library\Model\Adapter\WebAdapter::class => '/Library/Model/Adapter/WebAdapter.php',
    ],

    'lazyload' => [
        \Library\Model\Adapter\DbAdapterInterface::class => '/Library/Model/Adapter/MysqlPdoAdapter.php',
        \Library\Tools\RabbitMq\AmqpStreamConnectionService::class => '/Library/Tools/RabbitMq/AmqpStreamConnectionService.php'
    ],

    'handlers' => [
        \Library\Model\Adapter\DbAdapterInterface::class => function() 
        {
            return new \Library\Model\Adapter\MysqlPdoAdapter(DB_HOST, DB_NAME, DB_USER, DB_PASS);
        },

        \Library\Model\Adapter\WebAdapter::class => function() 
        {
            $mysqlPdoAdapeter = Loader::getInstance(\Library\Model\Adapter\DbAdapterInterface::class);
            $webAdapter =  new \Library\Model\Adapter\WebAdapter($mysqlPdoAdapeter);
            \Library\Model\Repository::setAdapter($webAdapter);

            return $webAdapter;
        },

        \Library\Tools\RabbitMq\AmqpStreamConnectionService::class => function() 
        {
            return new \Library\Tools\RabbitMq\AmqpStreamConnectionService(RABBIT_HOST, RABBIT_PORT, RABBIT_USER, RABBIT_PASS);
        }
    ]
];