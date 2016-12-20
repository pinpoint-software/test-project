<?php
namespace Application\Domain\Event;

class SubmitLinkTest extends \PHPUnit_Framework_TestCase
{
    public function testSubmitLinkConstructor()
    {
        $event = new SubmitLink('Title', 'http://example.com', '123', '2016-12-20 20:51:04');

        $this->assertEquals('Title', $event->title());
        $this->assertEquals('http://example.com', $event->url());
        $this->assertEquals('123', $event->submitterId());
        $this->assertEquals('2016-12-20 20:51:04', $event->created());
    }
}
