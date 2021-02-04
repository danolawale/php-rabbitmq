<?php

namespace Tests;

abstract class AbstractTestCaseService
    extends \PHPUnit\DbUnit\TestCase
{
    private $_conn = null;
    private static $_adapter = null;

    public function setUp(): void
    {
        ini_set('memory_limit', '-1');

        parent::setUp();
    }

    public function tearDown(): void
    {
        ini_set('memory_limit', '-1');

        parent::tearDown();
    }

    public function getAdapter()
    {
        if(!self::$_adapter)
        {
            self::$_adapter = new \Library\Model\Adapter\MysqlPdoAdapter(DB_HOST_TEST, DB_NAME_TEST, DB_USER_TEST, DB_PASS_TEST);
        }

        return self::$_adapter;
    }

    public function getConnection()
    {
        if(!$this->_conn)
        {
            $this->_conn = $this->getAdapter()->getConnection();
        }

        return $this->createDefaultDBConnection( $this->_conn );
    }

    public function getDataset()
    {
        return $this->createArrayDataSet([]);
    }
}