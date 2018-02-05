<?php
namespace Application\Domain\Gateway;

use DateTime;

interface LinkWrite
{
    public function create($title, $url, $submitterId, DateTime $created, $userText);
}
