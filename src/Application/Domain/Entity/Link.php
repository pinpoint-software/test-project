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
    private $externalLink;

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
        // if this Link's userText field is not empty, assume that this
        // particular instance will link to the text and set the url
        // appropriately.
        // if it was supposed to link to a URL, it will have been handled
        // by the LinkEvent gateway...namely LinkEvent::submit() and
        // userText will be an empty string
        if (!empty($userText)) {
            $this->url = "text/?id=$id";
            // while we're here, determine if this is an external or internal
            // link
            $this->externalLink =  false;
        } else {
            $this->url = $url;
            $this->externalLink =  true;
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

    public function externalLink()
    {
        return $this->externalLink;
    }
}
