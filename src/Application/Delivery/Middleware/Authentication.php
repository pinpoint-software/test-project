<?php
namespace Application\Delivery\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr7Middlewares\Middleware\AuraSession;

class Authentication
{
    public function __invoke(Request $request, Response $response, callable $next)
    {
        $session = AuraSession::getSession($request);
        $segment = $session->getSegment('Authentication');

        $user = [
            'id' => $segment->get('id', false),
            'firstName' => $segment->get('firstName', false),
            'lastName' => $segment->get('lastName', false),
        ];

        $request = $request->withAttribute('user', $user);

        $response = $next($request, $response);
        return $response;
    }
}
