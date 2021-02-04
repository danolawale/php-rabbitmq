<?php

namespace Library\Model\Adapter;

final class WebAdapter
    implements AdapterServiceInterface
{
    private DbAdapterInterface $adapter;

    public function __construct(DbAdapterInterface $adapter)
    {
        $this->_adapter = $adapter;
    }

    public function getConnection()
    {
        return $this->_adapter->getConnection();
    }

    public function getFetchType(string $type): int
    {
        $fetchTypes = [
            'assoc' => $this->_adapter::FETCH_ASSOC,
            'index' => $this->_adapter::FETCH_NUM
        ];

        return $fetchTypes[$type] ?? $this->_adapter::FETCH_ASSOC;
    }

    public function quote(string $val): string
    {
        return $this->getConnection()->quote($val);
    }

    public function getLastInsertedId(): int
    {
        return $this->getConnection()->lastInsertId();
    }

    public function execute(string $sql, array $bind = [])
    {
        try
        {
             $sth = $this->getConnection()->prepare($sql);
             $sth->execute($bind);
 
             return $sth;
        }
        catch(\Exception $e)
        {
            exit("Database query failed. ". $e->getMessage());
        }
    }

    public function fetchAll(string $sql, array $bind = []): array
    {
        return $this->execute($sql, $bind)->fetchAll();
    }

    public function fetchColumn(string $sql, array $bind = [])
    {
        return $this->execute($sql, $bind)->fetchColumn();
    }

    public function fetchOne(string $sql, array $bind = [])
    {
        return $this->fetchAll($sql, $bind)[0] ?? null;
    }
}