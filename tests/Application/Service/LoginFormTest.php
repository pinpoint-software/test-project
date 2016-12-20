<?php
namespace Application\Service;

class LoginFormTest extends \PHPUnit_Framework_TestCase
{
    public function testInvoke()
    {
        $service = new LoginForm();
        $payload = ($service)();

        $this->assertTrue($payload['success']);
        $this->assertFalse($payload['warning']);
    }

    public function testInvokeWithWarning()
    {
        $service = new LoginForm();
        $payload = ($service)('Warning');

        $this->assertTrue($payload['success']);
        $this->assertEquals('Warning', $payload['warning']);
    }
}
