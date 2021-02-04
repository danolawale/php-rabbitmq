<?php

namespace Tests\IntegrationTests;

class CreateReadUpdateDeleteTest
    extends \Tests\AbstractTestProxyService
{
    public function test_create()
    {
        $newUser = [
            'firstname' => 'create',
            'lastname' => 'user3',
            'email' => 'create@email.com',
            'username' => 'createuser3',
            'password' => 'pass123',
            'date_created' => '2020-12-17 15:30:00',
            'date_updated' => '2020-12-17 15:30:00'
        ];

        $userAccount = new \Library\Model\Entity\UserAccount(new \Library\Model\Adapter\WebAdapter($this->getAdapter()));
        $userAccount = $userAccount->save($newUser);
        
        $this->assertEquals([
            'id' => 3,
            'firstname' => 'create',
            'lastname' => 'user3',
            'email' => 'create@email.com',
            'username' => 'createuser3',
            'password' => 'pass123',
            'date_created' => '2020-12-17 15:30:00',
            'date_updated' => '2020-12-17 15:30:00'
        ], $userAccount->getFields());
    }

    public function test_read()
    {
        $usersRepository = \Library\Model\Entity\UserAccount::getRepository();

        $users = $usersRepository::fetchAllUsers();

        $this->assertEquals([
            [
                'id' => 1,
                'firstname' => 'first1',
                'lastname' => 'last1',
                'email' => 'first1@test.com',
                'username' => 'userfirst1',
                'password' => 'pass1',
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
                'date_created' => '2020-01-01 00:00:00',
                'date_updated' => '2020-01-01 00:00:00'
            ]
        ], $this->getEntitiesFields($users));
    }

    public function test_update()
    {
        $usersRepository = \Library\Model\Entity\UserAccount::getRepository();

        $user = $usersRepository::fetchUserById(2);

        $user->username = 'update-test';
        $user->email = 'first2@update-test.com';

        $user = $user->save();

        $this->assertEquals([
            'id' => 2,
            'firstname' => 'first2',
            'lastname' => 'last2',
            'email' => 'first2@update-test.com',
            'username' => 'update-test',
            'password' => 'pass2',
            'date_created' => '2020-01-01 00:00:00',
            'date_updated' => '2020-01-01 00:00:00'
        ], $user->getFields());
    }

    public function test_delete()
    {
        $usersRepository = \Library\Model\Entity\UserAccount::getRepository();

        $user = $usersRepository::fetchUserById(2);

        $user = $user->delete();

        $this->assertNull($user);
    }

    public function getDataset()
    {
        return $this->createArrayDataset([
            'user_accounts' => [
                [
                    'id' => 1,
                    'firstname' => 'first1',
                    'lastname' => 'last1',
                    'email' => 'first1@test.com',
                    'username' => 'userfirst1',
                    'password' => 'pass1',
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
                    'date_created' => '2020-01-01 00:00:00',
                    'date_updated' => '2020-01-01 00:00:00'
                ]
            ]
        ]);
    }
}