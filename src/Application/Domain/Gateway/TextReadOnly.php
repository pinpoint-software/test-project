<?php
namespace Application\Domain\Gateway;

interface TextReadOnly
{
    public function getRecentTexts();
    public function getText($id);
}
