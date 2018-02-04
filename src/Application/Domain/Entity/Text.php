<?php
namespace Application\Domain\Entity;

use DateTime;
use DateTimeZone;

class Text
{
    private $id;
    private $title;
    private $text;
    private $submitter;
    private $created;
    private $updated;

    public function __construct(
        $id,
        $title,
        $text,
        User $submitter,
        DateTime $created,
        DateTime $updated
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->text = $text;
        $this->submitter = $submitter;
        $this->created = $created;
        $this->updated = $updated;
    }

    public static function createLink($title, $text, User $submitter)
    {
        $updated = $created = new DateTime('now', new DateTimeZone('UTC'));
        return new static(null, $title, $text, $submitter, $created, $updated);
    }

    public function id()
    {
        return $this->id;
    }

    public function title()
    {
        return $this->title;
    }

    public function text()
    {
        return $this->text;
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
