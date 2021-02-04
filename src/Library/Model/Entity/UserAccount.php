<?php

namespace Library\Model\Entity;

class UserAccount
    extends \Library\Model\AbstractEntity
    implements \Library\Model\EntityInterface
{
    public static $table_name = 'user_accounts';
    public static $primary_key = 'id';

    protected static $columns = [
        "id",
        "firstname",
        "lastname",
        "username",
        "email",
        "password",
        "date_created",
        "date_updated"
    ];

    public static function getRepository(): string
    {
        return \Library\Model\Repository\UserAccountRepository::class;
    }

    public function fetchOne(int $id): \Library\Model\Entity\UserAccount 
    {
        return self::getRepository()::fetchUserById($id);
    }

    protected function _createOne(array $data): \Library\Model\Entity\UserAccount 
    {
        unset($data[self::$primary_key]);

        $rowCount = self::getRepository()::createUser($data);

        return $rowCount ? $this->fetchOne($this->_adapter->getLastInsertedId()) : null;
    }

    protected function _updateOne(array $data): \Library\Model\Entity\UserAccount
    {
        $primaryKeyValue = $data[self::$primary_key];

        if($primaryKeyValue)
        {
            $rowCount = self::getRepository()::updateUser($data, self::$primary_key);

            return $rowCount ? $this->fetchOne($data[self::$primary_key]) : null;
        }
    }

    protected function _deleteOne()
    {
        if($this->{self::$primary_key})
        {
            $rowCount = self::getRepository()::deleteUser(self::$primary_key, $this->{self::$primary_key});

            return $rowCount ? null : $this->fetchOne($this->{self::$primary_key});
        }
    }
}