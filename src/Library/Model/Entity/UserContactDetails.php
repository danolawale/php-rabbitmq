<?php

namespace Library\Model\Entity;

class UserContactDetails
    extends \Library\Model\AbstractEntity
    implements \Library\Model\EntityInterface
{
    public static $table_name = 'user_contact_details';
    public static $primary_key = 'id';
    public static $foreign_key = 'user_id';

    protected static $columns = [
        "id",
        "user_id",
        "type",
        "address1",
        "address2",
        "address3",
        'city',
        'county',
        'post_code',
        'country',
        'country_code',
        'telephone',
        'mobile_telephone',
        'email',
        "date_created",
        "date_updated"
    ];

    public static function getRepository(): string
    {
        return \Library\Model\Repository\UserContactDetailsRepository::class;
    }

    public function fetchOne(int $id): \Library\Model\Entity\UserContactDetails
    {
        return self::getRepository()::fetchUserContactById($id);
    }

    protected function _createOne(array $data): \Library\Model\Entity\UserContactDetails
    {
        unset($data[self::$primary_key]);

        $rowCount = self::getRepository()::createUserContact($data);

        return $rowCount ? $this->fetchOne($this->_adapter->getLastInsertedId()) : null;
    }

    protected function _updateOne(array $data): \Library\Model\Entity\UserContactDetails
    {
        $primaryKeyValue = $data[self::$primary_key];

        if($primaryKeyValue)
        {
            $rowCount = self::getRepository()::updateUserContact($data, self::$primary_key);

            return $rowCount ? $this->fetchOne($data[self::$primary_key]) : null;
        }
    }

    protected function _deleteOne()
    {
        if($this->{self::$primary_key})
        {
            $rowCount = self::getRepository()::deleteUserContact(self::$primary_key, $this->{self::$primary_key});

            return $rowCount ? null : $this->fetchOne($this->{self::$primary_key});
        }
    }
}