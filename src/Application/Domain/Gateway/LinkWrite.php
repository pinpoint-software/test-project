<?php
namespace Application\Domain\Gateway;

use DateTime;

interface LinkWrite
{
    public function create($title, $url, $text, $submitterId, DateTime $created);
}
