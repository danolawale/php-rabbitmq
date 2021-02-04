<?php

namespace Tests\IntegrationTests\Library\Model\Repository;

class UserAccountRepositoryTest
    extends \Tests\AbstractTestProxyService
{
    private \Library\Model\Repository\UserAccountRepository $_repository;

    public function test_fetchAllUsers()
    {
        $usersRepository = \Library\Model\Entity\UserAccount::getRepository();

        $users = $usersRepository::fetchAllUsers();

        $this->assertCount(3, $users);

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
            ],
            [
                'id' => 3,
                'firstname' => 'first3',
                'lastname' => 'last3',
                'email' => 'first3@test.com',
                'username' => 'userfirst3',
                'password' => 'pass3',
                'date_created' => '2020-01-01 00:00:00',
                'date_updated' => '2020-01-01 00:00:00'
            ]
        ], $this->getEntitiesFields($users));
    }

    public function test_fetchSingleUser()
    {
        $usersRepository = \Library\Model\Entity\UserAccount::getRepository();

        $user = $usersRepository::fetchUserById(1);

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
        ], $this->getEntitiesFields([$user]));
    }

    public function test_createUser()
    {
        $usersRepository = \Library\Model\Entity\UserAccount::getRepository();
        $rowCount = $usersRepository::createUser([
            'firstname' => 'Dev',
            'lastname' => 'Test',
            'email' => 'dev@test.com',
            'username' =>'devtest',
            'password' => 'testpass'
        ]);

        $this->assertEquals(1, $rowCount);
    }

    public function test_updateUser()
    {
        $usersRepository = \Library\Model\Entity\UserAccount::getRepository();

        $rowCount = $usersRepository::updateUser([
            'id' => 1,
            'firstname' => 'Dev',
            'lastname' => 'Test',
            'email' => 'dev@test.com',
        ], 'id');

        $this->assertEquals(1, $rowCount);
    }

    public function test_deleteUser()
    {
        $usersRepository = \Library\Model\Entity\UserAccount::getRepository();

        $rowCount = $usersRepository::deleteUser('id', '2');

        $this->assertEquals(1, $rowCount);
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
                ],
                [
                    'id' => 3,
                    'firstname' => 'first3',
                    'lastname' => 'last3',
                    'email' => 'first3@test.com',
                    'username' => 'userfirst3',
                    'password' => 'pass3',
                    'date_created' => '2020-01-01 00:00:00',
                    'date_updated' => '2020-01-01 00:00:00'
                ]
            ]
        ]);
    }
}