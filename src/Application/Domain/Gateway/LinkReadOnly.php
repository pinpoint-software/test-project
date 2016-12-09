<?php
namespace Application\Domain\Gateway;

interface LinkReadOnly
{
    public function getRecentLinks();
}
