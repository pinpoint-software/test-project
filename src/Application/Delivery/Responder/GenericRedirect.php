<?php
namespace Application\Delivery\Responder;

use Radar\Adr\Responder\ResponderAcceptsInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr7Middlewares\Middleware\AuraSession;

class GenericRedirect
{
    protected $request;
    protected $response;
    protected $segment;

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
        $target = $this->request->getAttribute('_target', '/');
        $this->response = $this->response
            ->withStatus(302)
            ->withHeader('location', $target);
    }

    protected function error($payload)
    {
        $this->segment->setFlash('warning', $payload['warning']);

        $this->response = $this->response
            ->withStatus(302)
            ->withHeader('location', $this->request->getRequestTarget());
    }
}
