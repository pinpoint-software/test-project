<?php
namespace Application\Domain\Gateway;

use DateTime;

interface TextWrite
{
    public function create($title, $text, $submitterId, DateTime $created);
}
