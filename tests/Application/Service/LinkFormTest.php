<?php
namespace Application\Service;

class LinkFormTest extends \PHPUnit_Framework_TestCase
{
    public function testInvoke()
    {
        $service = new LinkForm();
        $payload = ($service)();

        $this->assertTrue($payload['success']);
        $this->assertFalse($payload['warning']);
    }

    public function testInvokeWithWarning()
    {
        $service = new LinkForm();
        $payload = ($service)('Warning');

        $this->assertTrue($payload['success']);
        $this->assertEquals('Warning', $payload['warning']);
    }
}
