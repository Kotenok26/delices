<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Entity\User;

class UserUnitTest extends TestCase
{
    public function testIsTrue()
    {
        $user = new User();

        $user->setEmail('true@test.com')
            ->setFirstname('prenom')
            ->setLastname('nom')
            ->setPassword('password');

        $this->assertTrue($user->getEmail() === 'true@test.com');
        $this->assertTrue($user->getFirstname() === 'prenom');
        $this->assertTrue($user->getLastname() === 'nom');
        $this->assertTrue($user->getPassword() === 'password');
    }

    public function testIsFalse()
    {
        $user = new User();

        $user->setEmail('true@test.com')
            ->setFirstname('prenom')
            ->setLastname('nom')
            ->setPassword('password');


        $this->assertFalse($user->getEmail() === 'false@test.com');
        $this->assertFalse($user->getFirstname() === 'false');
        $this->assertFalse($user->getLastname() === 'false');
        $this->assertFalse($user->getPassword() === 'false');
    }

    public function testIsEmpty()
    {
        $user = new User();

        $this->assertEmpty($user->getEmail());
        $this->assertEmpty($user->getFirstname());
        $this->assertEmpty($user->getLastname());
        $this->assertEmpty($user->getPassword());
    }
}
