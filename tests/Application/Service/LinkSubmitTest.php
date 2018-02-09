<?php
namespace Application\Service;

use Application\Domain\Gateway\LinkEvent;

class LinkSubmitTest extends \PHPUnit_Framework_TestCase
{
    public function testInvoke()
    {
        $linkGateway = $this->createMock(LinkEvent::class);
        $linkGateway
            ->expects($this->once())
            ->method('submit')
            ->with(
                $this->equalTo('Example'),
                $this->equalTo('http://example.com/'),
                $this->equalTo('123')
            );

        $service = new LinkSubmit($linkGateway);
        $payload = ($service)('Example', 'http://example.com/', '123', 'some user text', 'on');

        $this->assertTrue($payload['success']);
    }

    public function testInvokeWithoutTitle()
    {
        $linkGateway = $this->createMock(LinkEvent::class);

        $service = new LinkSubmit($linkGateway);
        $payload = ($service)('', 'http://example.com/', '123', 'some user text');

        $this->assertFalse($payload['success']);
        $this->assertEquals('A Title is required', $payload['warning']);
    }

    public function testInvokeWithoutUrlWithText()
    {
        $linkGateway = $this->createMock(LinkEvent::class);

        $service = new LinkSubmit($linkGateway);
        $payload = ($service)('Example', '', '123', 'some user text');

        $this->assertTrue($payload['success']);

    }

    public function testInvokeWithoutUrlWithoutText()
    {
        $linkGateway = $this->createMock(LinkEvent::class);

        $service = new LinkSubmit($linkGateway);
        $payload = ($service)('Example', '', '123', '');

        $this->assertFalse($payload['success']);
        $this->assertEquals('Either a URL or a text description to be linked must be provided', $payload['warning']);
    }
    public function testInvokeWithoutSubmitter()
    {
        $linkGateway = $this->createMock(LinkEvent::class);

        $service = new LinkSubmit($linkGateway);
        $payload = ($service)('Example', 'http://example.com/', '', '');

        $this->assertFalse($payload['success']);
        $this->assertEquals('Must be logged in to submit links', $payload['warning']);
    }
}
