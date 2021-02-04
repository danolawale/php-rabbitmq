<?php

namespace Library\Model\Repository;

class UserContactDetailsRepository
    extends \Library\Model\Repository
{
    use \Library\Model\RepositoryTrait;

    public static function fetchAllContacts(): array
    {
        $sql = "SELECT * FROM user_contact_details";

        return parent::fetchEntities(\Library\Model\Entity\UserContactDetails::class, $sql);
    }

    public static function fetchUserContactById(int $id): \Library\Model\Entity\UserContactDetails
    {
        $sql = "SELECT * FROM user_contact_details ";
        $sql .= "WHERE id=" . parent::$_adapter->quote($id);

        return parent::fetchEntities(\Library\Model\Entity\UserContactDetails::class, $sql)[0];
    }

    public static function fetchUserContactsByUserId(int $userId): array
    {
        $sql = "SELECT * FROM user_contact_details ";
        $sql .= "WHERE user_id=" . parent::$_adapter->quote($userId);

        return parent::fetchEntities(\Library\Model\Entity\UserContactDetails::class, $sql);
    }

    public static function createUserContact(array $data): int
    {
        $data['user_id'] ??= self::fetchUserByEmail($data['email'])->id;

        return parent::create(self::_getCreateQuery($data, 'user_contact_details'), array_values($data));
    }

    public static function updateUserContact(array $data, string $primaryKey): int
    {
        $primaryKeyValue = $data[$primaryKey];
        unset($data[$primaryKey]);

        $data['user_id'] ??= self::fetchUserByEmail($data['email'])->id;

        $bind = array_values($data);
        $bind[] = $primaryKeyValue;

        return parent::update(self::_getUpdateQuery($data, $primaryKey, 'user_contact_details'), $bind);
    }

    public static function deleteUserContact(string $primaryKey, string $primaryKeyValue): int
    {
        $sql = "DELETE FROM user_contact_details WHERE {$primaryKey} = ?";

        return parent::delete($sql, [$primaryKeyValue]);
    }

    public static function fetchUserByEmail(string $email): ?\Library\Model\Entity\UserAccount
    {
        return UserAccountRepository::fetchUserByEmail($email);
    }
}