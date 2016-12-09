<?php
namespace Application\Domain\Gateway;

interface LinkEvent
{
    public function submit($title, $url, $submitterId);
}
