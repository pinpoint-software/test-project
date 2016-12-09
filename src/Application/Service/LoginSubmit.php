<?php
namespace Application\Service;

use Application\Domain\Gateway\UserReadOnly;

class LoginSubmit
{
    private $userGateway;

    public function __construct(UserReadOnly $userGateway)
    {
        $this->userGateway = $userGateway;
    }

    public function __invoke($email, $password)
    {
        $user = $this->userGateway->fetchByEmail($email);
        if (isset($user) && $user->matchesPassword($password)) {
            $payload = [
                'success' => true,
                'id' => $user->id(),
                'firstName' => $user->firstName(),
                'lastName' => $user->lastName(),
            ];
        } else {
            $payload = [
                'success' => false,
                'warning' => 'Invalid Email or Password',
            ];
        }
        return $payload;
    }
}
