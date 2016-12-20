<?php
namespace Application\Service;

use Application\Domain\Entity\User;
use Application\Domain\Gateway\UserReadOnly;
use DateTime;
use DateTimeZone;

class LoginSubmitTest extends \PHPUnit_Framework_TestCase
{
    public function testInvoke()
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

        $userGateway = $this->createMock(UserReadOnly::class);
        $userGateway
            ->expects($this->once())
            ->method('fetchByEmail')
            ->with(
                $this->equalTo('user@example.com')
            )
            ->willReturn($user);

        $service = new LoginSubmit($userGateway);
        $payload = ($service)('user@example.com', 'password');

        $this->assertTrue($payload['success']);
        $this->assertEquals('123', $payload['id']);
        $this->assertEquals('Test', $payload['firstName']);
        $this->assertEquals('User', $payload['lastName']);
    }

    public function testInvokeInvalidUser()
    {
        $user = null;

        $userGateway = $this->createMock(UserReadOnly::class);
        $userGateway
            ->expects($this->once())
            ->method('fetchByEmail')
            ->with(
                $this->equalTo('user@example.com')
            )
            ->willReturn($user);

        $service = new LoginSubmit($userGateway);
        $payload = ($service)('user@example.com', 'password');

        $this->assertFalse($payload['success']);
        $this->assertEquals('Invalid Email or Password', $payload['warning']);
    }

    public function testInvokeInvalidPassword()
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

        $userGateway = $this->createMock(UserReadOnly::class);
        $userGateway
            ->expects($this->once())
            ->method('fetchByEmail')
            ->with(
                $this->equalTo('user@example.com')
            )
            ->willReturn($user);

        $service = new LoginSubmit($userGateway);
        $payload = ($service)('user@example.com', 'bogus');

        $this->assertFalse($payload['success']);
        $this->assertEquals('Invalid Email or Password', $payload['warning']);
    }
}
