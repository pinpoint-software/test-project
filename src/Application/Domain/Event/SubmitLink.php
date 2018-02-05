<?php
namespace Application\Domain\Event;

class SubmitLink
{
    private $title;
    private $url;
    private $submitterId;
    private $created;
    private $userText;

    public function __construct($title, $url, $submitterId, $created, $userText)
    {
        $this->title = $title;
        $this->url = $url;
        $this->submitterId = $submitterId;
        $this->created = $created;
        $this->userText = $userText;
    }

    public function title()
    {
        return $this->title;
    }

    public function url()
    {
        return $this->url;
    }

    public function submitterId()
    {
        return $this->submitterId;
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
