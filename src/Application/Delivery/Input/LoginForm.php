<?php
namespace Application\Delivery\Input;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr7Middlewares\Middleware\AuraSession;

class LoginForm
{
    public function __invoke(Request $request)
    {
        $session = AuraSession::getSession($request);
        $segment = $session->getSegment('Authentication');
        $warning = $segment->getFlash('warning', false);

        return [$warning];
    }
}
