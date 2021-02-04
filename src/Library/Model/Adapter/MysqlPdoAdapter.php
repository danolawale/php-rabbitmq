<?php

namespace Library\Model\Adapter;

use \PDO, \PDOException;

final class MysqlPdoAdapter
    implements DbAdapterInterface
{
    CONST FETCH_ASSOC = PDO::FETCH_ASSOC;
    CONST FETCH_NUM = PDO::FETCH_NUM;

    private string $dbhost;
    private string $dbname;
    private string $dbuser;
    private string $dbpass;

    private string $_dsn;
    private static $_db = null;

    public function __construct(
        string $dbhost, string $dbname, string $dbuser, string $dbpass)
    {
        $this->_dbhost = $dbhost;
        $this->_dbname = $dbname;
        $this->_dbuser = $dbuser;
        $this->_dbpass = $dbpass;

        $this->_dsn = "mysql:host=". $dbhost . ";dbname=". $dbname . ";charset=utf8mb4";
    }

    private function _getOptions()
    {
        return [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
    }

    public function getConnection()
    {
        try
        {
            if(!self::$_db)
            {
                self::$_db = new PDO($this->_dsn, $this->_dbuser, $this->_dbpass, $this->_getOptions());
            }

            return self::$_db;
        }
        catch(PDOException $e)
        {
            echo "Failed to connect to database. \n";
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }
}