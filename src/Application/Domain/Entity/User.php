<?php
namespace Application\Domain\Entity;

use DateTime;
use DateTimeZone;

class User
{
    private $id;
    private $email;
    private $password;
    private $firstName;
    private $lastName;
    private $created;
    private $updated;

    public function __construct(
        $id,
        $email,
        $password,
        $firstName,
        $lastName,
        DateTime $created,
        DateTime $updated
    ) {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->created = $created;
        $this->updated = $updated;
    }

    public static function createUser($email, $password, $firstName, $lastName)
    {
        $updated = $created = new DateTime('now', new DateTimeZone('UTC'));
        $hashedPass = password_hash($password, PASSWORD_DEFAULT);
        return new static(null, $email, $hashedPass, $firstName, $lastName, $created, $updated);
    }

    public function id()
    {
        return $this->id;
    }

    public function email()
    {
        return $this->email;
    }

    public function matchesPassword($password)
    {
        return password_verify($password, $this->password);
    }

    public function firstName()
    {
        return $this->firstName;
    }

    public function lastName()
    {
        return $this->lastName;
    }
}
