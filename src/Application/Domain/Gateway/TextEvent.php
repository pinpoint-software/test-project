<?php
namespace Application\Domain\Gateway;

interface TextEvent
{
    public function submit($title, $text, $submitterId);
}
