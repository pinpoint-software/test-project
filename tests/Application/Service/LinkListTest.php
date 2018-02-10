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
        $linkWithText = Link::createLink('Example', 'http://example.com/', $user, 'Test Text');

        $linkGateway = $this->createMock(LinkReadOnly::class);
        $linkGateway->method('getRecentLinks')->willReturn([$linkWithText]);

        $service = new LinkList($linkGateway);
        $payload = ($service)();

        $this->assertTrue($payload['success']);
        $this->assertInternalType('array', $payload['links']);
        $this->assertArrayHasKey(0, $payload['links']);
        $this->assertEquals('Example', $payload['links'][0]['title']);
        $this->assertRegExp('/text\/\?id=\d*/', $payload['links'][0]['url']);
        $this->assertEquals('Test', $payload['links'][0]['firstName']);
        $this->assertEquals('User', $payload['links'][0]['lastName']);
        $this->assertInstanceOf('DateTime', $payload['links'][0]['created']);




        $linkWithOutText = Link::createLink('Example', 'http://example.com/', $user, '');

        $linkGateway = $this->createMock(LinkReadOnly::class);
        $linkGateway->method('getRecentLinks')->willReturn([$linkWithOutText]);

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
