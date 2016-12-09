<?php
namespace Application\Service;

class LoginForm
{
    public function __invoke($warning = false)
    {
        return [
            'success' => true,
            'warning' => $warning,
        ];
    }
}
