<?php

namespace Library\Model\Repository;

class UserAccountRepository
    extends \Library\Model\Repository
{
    use \Library\Model\RepositoryTrait;

    public static function fetchAllUsers(): array
    {
        $sql = "SELECT * FROM user_accounts";

        return parent::fetchEntities(\Library\Model\Entity\UserAccount::class, $sql);
    }

    public static function fetchUserById(int $id): \Library\Model\Entity\UserAccount
    {
        $sql = "SELECT * FROM user_accounts ";
        $sql .= "WHERE id=" . parent::$_adapter->quote($id);

        return parent::fetchEntities(\Library\Model\Entity\UserAccount::class, $sql)[0];
    }

    public static function fetchUserByEmail(string $email): ?\Library\Model\Entity\UserAccount
    {
        $sql = "SELECT * FROM user_accounts ";
        $sql .= "WHERE email=" . parent::$_adapter->quote($email);

        return parent::fetchEntities(\Library\Model\Entity\UserAccount::class, $sql)[0] ?? null;
    }

    public static function createUser(array $data): int
    {
        if(self::fetchUserByEmail($data['email']))
        {
            throw new \Exception("User with email already exists");
        }

        return parent::create(self::_getCreateQuery($data, 'user_accounts'), array_values($data));
    }

    public static function updateUser(array $data, string $primaryKey): int
    {
        $primaryKeyValue = $data[$primaryKey];
        unset($data[$primaryKey]);

        $bind = array_values($data);
        $bind[] = $primaryKeyValue;

        return parent::update(self::_getUpdateQuery($data, $primaryKey, 'user_accounts'), $bind);
    }

    public static function deleteUser(string $primaryKey, string $primaryKeyValue): int
    {
        $sql = "DELETE FROM user_accounts WHERE {$primaryKey} = ?";

        return parent::delete($sql, [$primaryKeyValue]);
    }
}