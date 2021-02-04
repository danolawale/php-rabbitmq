<?php

class Loader
{
    private static $instances;

    private static $factories;

    private static function getFactories()
    {
        $factories = require_once "factory.loader2.php";

        self::$factories = $factories;

        return $factories;
    }

    private static function getClassesToPreload()
    {
        if(self::$factories)
        {
            return self::$factories['preload'];
        }
        else
        {
            return self::getFactories()['preload'];
        }
    }

    private static function getClassesToLazyload()
    {
        if(self::$factories)
        {
            return self::$factories['lazyload'];
        }
        else
        {
            return self::getFactories()['lazyload'];
        }
    }

    private static function getInstanceHandlers()
    {
        if(self::$factories)
        {
            return self::$factories['handlers'];
        }
        else
        {
            return self::getFactories()['handlers'];
        }
    }

    private static function setInstance(string $key, $instance)
    {
        self::$instances[$key] = $instance;
    }

    public static function getInstance(string $key)
    {
        if(self::$instances[$key] ?? null)
        {
            return self::$instances[$key];
        }
        else
        {
            if(!($file = self::getClassesToPreload()[$key] ?? null))
            {
                $file = self::getClassesToLazyLoad()[$key] ?? null;
            }

            if($file)
            {
                require_once(PROJECT_PATH . $file);

                $instance = self::getInstanceHandlers()[$key]();

                self::setInstance($key, $instance);

                return $instance;
            }
            else
            {
                return null;
            }
        }
    }

    public static function preloadClasses(): array
    {
        $instances = [];

        foreach(self::getClassesToPreload() as $key => $class)
        {
            $instances[$key] = self::getInstance($key);
        }

        return $instances;
    }
}