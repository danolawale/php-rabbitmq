<?php

namespace Tests\IntegrationTests\Library\Model\Repository;

class UserContactDetailsRepositoryTest
    extends \Tests\AbstractTestProxyService
{
    private \Library\Model\Repository\UserContactDetailsRepository $_repository;

    public function test_fetchAllContacts()
    {
        $userContactsRepository = \Library\Model\Entity\UserContactDetails::getRepository();

        $contacts = $userContactsRepository::fetchAllContacts();

        $this->assertCount(3, $contacts);

        $this->assertEquals([
            [
                'id' => 1,
                'user_id' => 1,
                'type' => 1,
                'address1' => 'line 1',
                'address2' => 'line 2',
                'address3' => null,
                'city' => null,
                'county' => null,
                'post_code' => '1234',
                'country' => null,
                'country_code' => 'GB',
                'telephone' => null,
                'mobile_telephone' => null,
                'email' => null,
                'date_created' => '2020-01-01 00:00:00',
                'date_updated' => '2020-01-01 00:00:00'
            ],
            [
                'id' => 2,
                'user_id' => 1,
                'type' => 2,
                'address1' => 'line 1b',
                'address2' => 'line 2b',
                'address3' => null,
                'city' => null,
                'county' => null,
                'post_code' => '1235',
                'country' => null,
                'country_code' => 'GB',
                'telephone' => null,
                'mobile_telephone' => null,
                'email' => null,
                'date_created' => '2020-01-01 00:00:00',
                'date_updated' => '2020-01-01 00:00:00'
            ],
            [
                'id' => 3,
                'user_id' => 2,
                'type' => 1,
                'address1' => 'line 1c',
                'address2' => 'line 2c',
                'address3' => null,
                'city' => null,
                'county' => null,
                'post_code' => '1236',
                'country' => null,
                'country_code' => 'GB',
                'telephone' => null,
                'mobile_telephone' => null,
                'email' => null,
                'date_created' => '2020-01-01 00:00:00',
                'date_updated' => '2020-01-01 00:00:00'
            ],
        ], $this->getEntitiesFields($contacts));
    }

    public function test_fetchSingleContact()
    {
        $userContactsRepository = \Library\Model\Entity\UserContactDetails::getRepository();

        $contact = $userContactsRepository::fetchUserContactById(1);

        $this->assertEquals([
            [
                'id' => 1,
                'user_id' => 1,
                'type' => 1,
                'address1' => 'line 1',
                'address2' => 'line 2',
                'address3' => null,
                'city' => null,
                'county' => null,
                'post_code' => '1234',
                'country' => null,
                'country_code' => 'GB',
                'telephone' => null,
                'mobile_telephone' => null,
                'email' => null,
                'date_created' => '2020-01-01 00:00:00',
                'date_updated' => '2020-01-01 00:00:00'

            ],
        ], $this->getEntitiesFields([$contact]));
    }

    public function test_createUserContact()
    {
        $userContactsRepository = \Library\Model\Entity\UserContactDetails::getRepository();
        $rowCount = $userContactsRepository::createUserContact([
            'user_id' => 2,
            'type' => 2,
            'address1' => 'address1',
            'post_code' => 'post1'
        ]);

        $this->assertEquals(1, $rowCount);
    }

    public function test_updateUserContact()
    {
        $userContactsRepository = \Library\Model\Entity\UserContactDetails::getRepository();

        $rowCount = $userContactsRepository::updateUserContact([
            'id' => 2,
            'type' => 2,
            'email' => 'test1@test.com',
            'address1' => 'address1',
            'post_code' => 'post1'
        ], 'id');

        $this->assertEquals(1, $rowCount);
    }

    public function test_deleteUser()
    {
        $userContactsRepository = \Library\Model\Entity\UserContactDetails::getRepository();

        $rowCount = $userContactsRepository::deleteUserContact('id', '2');

        $this->assertEquals(1, $rowCount);
    }

    public function getDataset()
    {
        return $this->createArrayDataset([
            'user_accounts' => [],
            'user_accounts' => [
                [
                    'id' => 1,
                    'firstname' => 'first1',
                    'lastname' => 'last1',
                    'email' => 'first1@test.com',
                    'username' => 'userfirst1',
                    'password' => 'pass1',
                    'email' => 'test1@test.com',
                    'date_created' => '2020-01-01 00:00:00',
                    'date_updated' => '2020-01-01 00:00:00'
                ],
                [
                    'id' => 2,
                    'firstname' => 'first2',
                    'lastname' => 'last2',
                    'email' => 'first2@test.com',
                    'username' => 'userfirst2',
                    'password' => 'pass2',
                    'email' => 'test2@test.com',
                    'date_created' => '2020-01-01 00:00:00',
                    'date_updated' => '2020-01-01 00:00:00'
                ]
            ],
            
            'user_contact_details' => [
                [
                    'id' => 1,
                    'user_id' => 1,
                    'type' => 1,
                    'address1' => 'line 1',
                    'address2' => 'line 2',
                    'post_code' => '1234',
                    'country_code' => 'GB',
                    'date_created' => '2020-01-01 00:00:00',
                    'date_updated' => '2020-01-01 00:00:00'
                ],
                [
                    'id' => 2,
                    'user_id' => 1,
                    'type' => 2,
                    'address1' => 'line 1b',
                    'address2' => 'line 2b',
                    'post_code' => '1235',
                    'country_code' => 'GB',
                    'date_created' => '2020-01-01 00:00:00',
                    'date_updated' => '2020-01-01 00:00:00'
                ],
                [
                    'id' => 3,
                    'user_id' => 2,
                    'type' => 1,
                    'address1' => 'line 1c',
                    'address2' => 'line 2c',
                    'post_code' => '1236',
                    'country_code' => 'GB',
                    'date_created' => '2020-01-01 00:00:00',
                    'date_updated' => '2020-01-01 00:00:00'
                ]
            ]

        ]);
    }
}