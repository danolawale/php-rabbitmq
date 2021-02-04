<?php

namespace Library\Model;

Trait RepositoryTrait
{
    private static function _getCreateQuery(array $data, string $tableName): string
    {
        $fields = array_keys($data);

        $columns = implode(', ', $fields);

        $placeholders = implode(', ', array_fill(0, count($fields), '?'));

        return "INSERT INTO {$tableName} ($columns) VALUES($placeholders)";
    }

    private static function _getUpdateQuery(array $data, string $primaryKey, string $tableName): string
    {
        $updateParams = array_reduce(array_keys($data), fn($acc, $ele) => $acc .= "{$ele} = ?,");
        $updateParams = substr($updateParams, 0, -1);
        
        return "UPDATE {$tableName} SET  {$updateParams} WHERE {$primaryKey} = ?";
    }
}