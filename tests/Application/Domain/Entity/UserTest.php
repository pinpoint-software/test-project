<?php
namespace Application\Domain\Entity;

use DateTime;
use DateTimeZone;

class UserTest extends \PHPUnit_Framework_TestCase
{
    public function testUserConstructor()
    {
        $user = new User(
            '123',
            'user@example.com',
            password_hash('password', PASSWORD_DEFAULT),
            'Test',
            'User',
            new DateTime('2016-12-19 10:24:13', new DateTimeZone('UTC')),
            new DateTime('2016-12-20 20:51:04', new DateTimeZone('UTC'))
        );

        $this->assertEquals('123', $user->id());
        $this->assertEquals('user@example.com', $user->email());
        $this->assertEquals('Test', $user->firstName());
        $this->assertEquals('User', $user->lastName());
        $this->assertTrue($user->matchesPassword('password'));
        $this->assertFalse($user->matchesPassword('bogus'));
    }

    public function testCreateUserFactory()
    {
        $user = User::createUser(
            'user@example.com',
            'password',
            'Test',
            'User'
        );

        $this->assertNull($user->id());
        $this->assertEquals('user@example.com', $user->email());
        $this->assertEquals('Test', $user->firstName());
        $this->assertEquals('User', $user->lastName());
        $this->assertTrue($user->matchesPassword('password'));
        $this->assertFalse($user->matchesPassword('bogus'));
    }
}
