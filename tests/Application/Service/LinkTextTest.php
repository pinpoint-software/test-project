<?php
namespace Application\Service;

use Application\Domain\Gateway\TextReadOnly;
use Application\Domain\Entity\Link;
use Application\Domain\Entity\User;

class LinkTextTest extends \PHPUnit_Framework_TestCase
{
    public function testInvoke()
    {
        $user = User::createUser('user@example.com', 'password', 'Test', 'User');
        $link = Link::createLink('Example', 'http://example.com/', 'Description', $user);

        $textGateway = $this->createMock(TextReadOnly::class);
        
        $textGateway
            ->expects($this->once())
            ->method('getLink')
            ->with(
                $this->equalTo('1')
            )
            ->willReturn($link);
        
        $service = new LinkText($textGateway);
        $payload = ($service)('1');

        $this->assertTrue($payload['success']);
    }
}
