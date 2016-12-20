<?php
namespace Application\Service;

class GenericTest extends \PHPUnit_Framework_TestCase
{
    public function testInvoke()
    {
        $service = new Generic();
        $payload = ($service)();

        $this->assertTrue($payload['success']);
    }
}
