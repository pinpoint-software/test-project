<?php
namespace Application\Domain\Entity;

use DateTime;
use DateTimeZone;

class Link
{
    private $id;
    private $title;
    private $url;
	private $text;
    private $submitter;
    private $created;
    private $updated;

    public function __construct(
        $id,
        $title,
        $url,
		$text,
        User $submitter,
        DateTime $created,
        DateTime $updated
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->url = $url;
		$this->text = $text;
        $this->submitter = $submitter;
        $this->created = $created;
        $this->updated = $updated;
    }

    public static function createLink($title, $url, $text, User $submitter)
    {
        $updated = $created = new DateTime('now', new DateTimeZone('UTC'));
        return new static(null, $title, $url, $text, $submitter, $created, $updated);
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
