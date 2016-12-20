<?php
namespace Application\Domain\Entity;

use DateTime;
use DateTimeZone;

class Link
{
    private $id;
    private $title;
    private $url;
    private $submitter;
    private $created;
    private $updated;

    public function __construct(
        $id,
        $title,
        $url,
        User $submitter,
        DateTime $created,
        DateTime $updated
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->url = $url;
        $this->submitter = $submitter;
        $this->created = $created;
        $this->updated = $updated;
    }

    public static function createLink($title, $url, User $submitter)
    {
        $updated = $created = new DateTime('now', new DateTimeZone('UTC'));
        return new static(null, $title, $url, $submitter, $created, $updated);
    }

    public function id()
    {
        return $this->id;
    }

    public function title()
    {
        return $this->title;
    }

    public function url()
    {
        return $this->url;
    }

    public function submitter()
    {
        return $this->submitter;
    }

    public function created()
    {
        return $this->created;
    }
}
