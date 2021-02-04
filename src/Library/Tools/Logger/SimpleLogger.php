<?php

namespace Library\Tools\Logger;

class SimpleLogger
{
    private static string $_file;

    private static function _getLogFile()
    {
        $file = '../../../private/log.txt';

        if(!file_exists($file))
        {
            file_put_contents($file, '');
        }

        return $file;
    }

    public static function log(string $message)
    {
        $logfile = self::_getLogFile();

        $datetime = date('Y-m-d H:i:s');

        $message = "{$datetime}\t{$message}";

        file_put_contents($logfile, $message, FILE_APPEND | LOCK_EX);
    }
}