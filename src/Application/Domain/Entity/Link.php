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
    private $userText;

    public function __construct(
        $id,
        $title,
        $url,
        User $submitter,
        DateTime $created,
        DateTime $updated,
        $userText
    ) {
        $this->id = $id;
        $this->title = $title;
        if (!empty($userText)) {
            $this->url = "text/?id=$id";
        } else {
            $this->url = $url;
        }
        $this->submitter = $submitter;
        $this->created = $created;
        $this->updated = $updated;
        $this->userText = $userText;
    }

    public static function createLink($title, $url, User $submitter, $userText)
    {
        $updated = $created = new DateTime('now', new DateTimeZone('UTC'));
        return new static(null, $title, $url, $submitter, $created, $updated, $userText);
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
    public function userText()
    {
        return $this->userText;
    }
}
