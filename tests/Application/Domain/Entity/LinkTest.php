<?php
namespace Application\Domain\Entity;

use DateTime;
use DateTimeZone;

class LinkTest extends \PHPUnit_Framework_TestCase
{
    public function testLinkConstructorWithoutText()
    {
        $submitter = new User(
            '123',
            'user@example.com',
            password_hash('password', PASSWORD_DEFAULT),
            'Test',
            'User',
            new DateTime('2016-12-19 10:24:13', new DateTimeZone('UTC')),
            new DateTime('2016-12-20 20:51:04', new DateTimeZone('UTC'))
        );

        $link = new Link(
            '123',
            'Title',
            'http://example.com/',
            $submitter,
            new DateTime('2016-12-19 10:24:13', new DateTimeZone('UTC')),
            new DateTime('2016-12-20 20:51:04', new DateTimeZone('UTC')),
            ''
        );

        $this->assertEquals('123', $link->id());
        $this->assertEquals('Title', $link->title());
        $this->assertEquals('http://example.com/', $link->url());
        $this->assertEquals($submitter, $link->submitter());
        $this->assertEquals('2016-12-19 10:24:13', $link->created()->format('Y-m-d H:i:s'));
        $this->assertEquals('', $link->userText());
    }
    public function testLinkConstructorWithText()
    {
        $submitter = new User(
            '123',
            'user@example.com',
            password_hash('password', PASSWORD_DEFAULT),
            'Test',
            'User',
            new DateTime('2016-12-19 10:24:13', new DateTimeZone('UTC')),
            new DateTime('2016-12-20 20:51:04', new DateTimeZone('UTC'))
        );

        $link = new Link(
            '123',
            'Title',
            'http://example.com/',
            $submitter,
            new DateTime('2016-12-19 10:24:13', new DateTimeZone('UTC')),
            new DateTime('2016-12-20 20:51:04', new DateTimeZone('UTC')),
            'some user text'
        );

        $this->assertEquals('123', $link->id());
        $this->assertEquals('Title', $link->title());
        $this->assertRegExp('/text\/\?id=\d*/', $link->url());
        $this->assertEquals($submitter, $link->submitter());
        $this->assertEquals('2016-12-19 10:24:13', $link->created()->format('Y-m-d H:i:s'));
        $this->assertEquals('some user text', $link->userText());
    }

    public function testCreateLinkFactoryWithoutText()
    {
        $submitter = new User(
            '123',
            'user@example.com',
            password_hash('password', PASSWORD_DEFAULT),
            'Test',
            'User',
            new DateTime('2016-12-19 10:24:13', new DateTimeZone('UTC')),
            new DateTime('2016-12-20 20:51:04', new DateTimeZone('UTC'))
        );

        $link = Link::createLink(
            'Title',
            'http://example.com/',
            $submitter,
            ''

        );

        $this->assertNull($link->id());
        $this->assertEquals('Title', $link->title());
        $this->assertEquals('http://example.com/', $link->url());
        $this->assertEquals($submitter, $link->submitter());
        $this->assertEquals('', $link->userText());
    }
    public function testCreateLinkFactoryWithText()
    {
        $submitter = new User(
            '123',
            'user@example.com',
            password_hash('password', PASSWORD_DEFAULT),
            'Test',
            'User',
            new DateTime('2016-12-19 10:24:13', new DateTimeZone('UTC')),
            new DateTime('2016-12-20 20:51:04', new DateTimeZone('UTC'))
        );

        $link = Link::createLink(
            'Title',
            'http://example.com/',
            $submitter,
            'some user text'

        );

        $this->assertNull($link->id());
        $this->assertEquals('Title', $link->title());
        $this->assertRegExp('/text\/\?id=\d*/', $link->url());
        $this->assertEquals($submitter, $link->submitter());
        $this->assertEquals('some user text', $link->userText());
    }
}
