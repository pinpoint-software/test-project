<?php
namespace Application\Service;

use Application\Domain\Entity\Link;
use Application\Domain\Entity\User;
use Application\Domain\Gateway\LinkReadOnly;

class LinkListTest extends \PHPUnit_Framework_TestCase
{
    public function testInvoke()
    {
        $user = User::createUser('user@example.com', 'password', 'Test', 'User');
        $link = Link::createLink('Example', 'http://example.com/', 'Description', $user);

        $linkGateway = $this->createMock(LinkReadOnly::class);
        $linkGateway->method('getRecentLinks')->willReturn([$link]);

        $service = new LinkList($linkGateway);
        $payload = ($service)();

        $this->assertTrue($payload['success']);
        $this->assertInternalType('array', $payload['links']);
        $this->assertArrayHasKey(0, $payload['links']);
        $this->assertEquals('Example', $payload['links'][0]['title']);
        $this->assertEquals('http://example.com/', $payload['links'][0]['url']);
        $this->assertEquals('Test', $payload['links'][0]['firstName']);
        $this->assertEquals('User', $payload['links'][0]['lastName']);
        $this->assertInstanceOf('DateTime', $payload['links'][0]['created']);
    }
}
