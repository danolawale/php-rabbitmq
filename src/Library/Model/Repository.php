<?php

namespace Library\Model;

class Repository
{
    protected static $_adapter = null;

   public static function setAdapter(Adapter\AdapterServiceInterface $adapter)
   {
       self::$_adapter = $adapter;
   }

   public static function getAdapter(): Adapter\AdapterServiceInterface
   {
       return self::$_adapter;
   }

    public static function fetchAll(string $sql, array $bind = []): array
    {
        return self::$_adapter->fetchAll($sql, $bind);
    }

    public static function fetchEntities(string $entityName, string $sql, $bind = []): array
    {
        $entities = [];
     
        $sth = self::$_adapter->execute($sql, $bind);

        while( $row = $sth->fetch(self::$_adapter->getFetchType('assoc')) )
        {
            $entity = $entityName::init($row);

            $entity->isNew = false;

            $entities[] = $entity;
        }
    
        return $entities;
    }

    public static function create(string $sql, array $bind): int
    {
        return self::$_adapter->execute($sql, $bind)->rowCount();
    }

    public static function update(string $sql, array $bind): int
    {
        return self::$_adapter->execute($sql, $bind)->rowCount();
    }

    public static function delete(string $sql, array $bind): int
    {
        return self::$_adapter->execute($sql, $bind)->rowCount();
    }
}