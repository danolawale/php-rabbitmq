<?php

require_once "Loader.php";

function getClassesToPreload(): array
{
    return [
        \Library\Model\Adapter\DbAdapterInterface::class => '/Library/Model/Adapter/MysqlPdoAdapter.php',
        \Library\Model\Adapter\WebAdapter::class => '/Library/Model/Adapter/WebAdapter.php',
    ];
}

function getClassesToLazyLoad(): array
{
    return [
        \Library\Model\Adapter\DbAdapterInterface::class => '/Library/Model/Adapter/MysqlPdoAdapter.php',
        \Library\Tools\RabbitMq\AmqpStreamConnectionService::class => '/Library/Tools/RabbitMq/AmqpStreamConnectionService.php'
    ];
}

function getInstanceHandlers(): array
{
    return [
        \Library\Model\Adapter\DbAdapterInterface::class => function() 
        {
            return new \Library\Model\Adapter\MysqlPdoAdapter(DB_HOST, DB_NAME, DB_USER, DB_PASS);
        },

        \Library\Model\Adapter\WebAdapter::class => function() 
        {
            $mysqlPdoAdapeter = getInstance(\Library\Model\Adapter\DbAdapterInterface::class);
            $webAdapter =  new \Library\Model\Adapter\WebAdapter($mysqlPdoAdapeter);
            \Library\Model\Repository::setAdapter($webAdapter);

            return $webAdapter;
        },

        \Library\Tools\RabbitMq\AmqpStreamConnectionService::class => function() 
        {
            return new \Library\Tools\RabbitMq\AmqpStreamConnectionService(RABBIT_HOST, RABBIT_PORT, RABBIT_USER, RABBIT_PASS);
        }
    ];
}

function getInstance(string $key)
{
    if($instance = Loader::getInstance($key))
    {
        return $instance;
    }
    else
    {
        if(!($file = getClassesToPreload()[$key] ?? null))
        {
            $file = getClassesToLazyLoad()[$key] ?? null;
        }

        if($file)
        {
            require_once(PROJECT_PATH . $file);

            $instance = getInstanceHandlers()[$key]();

            Loader::setInstance($key,$instance);

            return $instance;
        }
        else
        {
            return null;
        }
    }
}

function preloadClasses(): array
{
    $instances = [];

    foreach(getClassesToPreload() as $key => $class)
    {
        require_once PROJECT_PATH . $class;

        $instance = getInstance($key);

        $instances[$key] = $instance;

        Loader::setInstance($key,$instance);
    }

    return $instances;
}
