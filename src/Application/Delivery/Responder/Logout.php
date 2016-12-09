<?php
namespace Application\Delivery\Responder;

use Radar\Adr\Responder\ResponderAcceptsInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr7Middlewares\Middleware\AuraSession;

class Logout implements ResponderAcceptsInterface
{
    protected $request;
    protected $response;
    protected $segment;

    public static function accepts()
    {
        return ['text/html', 'application/json'];
    }

    public function __invoke(
        Request $request,
        Response $response,
        array $payload
    ) {
        $session = AuraSession::getSession($request);

        $this->request = $request;
        $this->response = $response;
        $this->segment = $session->getSegment('Authentication');

        $this->success($payload);

        return $this->response;
    }

    protected function success($payload)
    {
        $this->segment->set('id', false);
        $this->segment->set('firstName', false);
        $this->segment->set('lastName', false);

        $this->response = $this->response
            ->withStatus(302)
            ->withHeader('location', '/login/');
    }
}
