<?php
namespace Application\Delivery\Responder;

use Radar\Adr\Responder\ResponderAcceptsInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr7Middlewares\Middleware\AuraSession;

class LoginSubmit implements ResponderAcceptsInterface
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

        if (isset($payload['success']) && true === $payload['success']) {
            $this->success($payload);
        } else {
            $this->error($payload);
        }

        return $this->response;
    }

    protected function success($payload)
    {
        $this->segment->set('id', $payload['id']);
        $this->segment->set('firstName', $payload['firstName']);
        $this->segment->set('lastName', $payload['lastName']);

        $this->response = $this->response
            ->withStatus(302)
            ->withHeader('location', '/');
    }

    protected function error($payload)
    {
        $this->segment->set('id', false);
        $this->segment->set('firstName', false);
        $this->segment->set('lastName', false);

        $this->segment->setFlash('warning', $payload['warning']);

        $this->response = $this->response
            ->withStatus(302)
            ->withHeader('location', '/login/');
    }
}
