<?php
namespace Application\Domain\Event;

class SubmitText
{
    private $title;
    private $text;
    private $submitterId;
    private $created;

    public function __construct($title, $text, $submitterId, $created)
    {
        $this->title = $title;
        $this->text = $text;
        $this->submitterId = $submitterId;
        $this->created = $created;
    }

    public function title()
    {
        return $this->title;
    }

    public function text()
    {
        return $this->text;
    }

    public function submitterId()
    {
        return $this->submitterId;
    }

    public function created()
    {
        return $this->created;
    }
}
