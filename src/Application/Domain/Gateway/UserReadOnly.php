<?php
namespace Application\Domain\Gateway;

interface UserReadOnly
{
    public function fetchByEmail($email);
}
