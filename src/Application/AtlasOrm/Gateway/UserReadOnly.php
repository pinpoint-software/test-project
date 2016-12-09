<?php
namespace Application\AtlasOrm\Gateway;

use Application\AtlasOrm\DataSource\User\UserMapper;
use Application\Domain\Entity\User;
use Application\Domain\Gateway\UserReadOnly as UserReadOnlyGateway;
use Atlas\Orm\Atlas;
use DateTime;
use DateTimeZone;

class UserReadOnly implements UserReadOnlyGateway
{
    private $atlas;

    public function __construct(Atlas $atlas)
    {
        $this->atlas = $atlas;
    }

    public function fetchByEmail($email)
    {
        $user = null;

        $userRecord = $this->atlas
            ->select(UserMapper::class)
            ->where('email = ?', $email)
            ->fetchRecord();

        if (false !== $userRecord) {
            $user = new User(
                $userRecord->id,
                $userRecord->email,
                $userRecord->password,
                $userRecord->first_name,
                $userRecord->last_name,
                new DateTime($userRecord->created, new DateTimeZone('UTC')),
                new DateTime($userRecord->updated, new DateTimeZone('UTC'))
            );
        }

        return $user;
    }
}
