<?php
namespace Application\Delivery\Responder;

use Radar\Adr\Responder\ResponderAcceptsInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Twig_Environment;

class Generic implements ResponderAcceptsInterface
{
    protected $request;
    protected $response;
    protected $twig;

    public function __construct(Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    public static function accepts()
    {
        return ['text/html', 'application/json'];
    }

    public function __invoke(
        Request $request,
        Response $response,
        array $payload
    ) {
        $this->request = $request;
        $this->response = $response;
        if (isset($payload['success']) && true === $payload['success']) {
            $payload['user'] = $request->getAttribute('user', false);
            $this->success($payload);
        } else {
            $this->error($payload);
        }
        return $this->response;
    }

    protected function jsonBody(array $data)
    {
        $this->response = $this->response->withHeader('Content-Type', 'application/json');
        $this->response->getBody()->write(json_encode($data));
    }

    protected function htmlBody(array $data)
    {
        $view = $this->request->getAttribute('_view', 'index.html.twig');
        $body = $this->twig->render($view, $data);

        $this->response = $this->response->withHeader('Content-Type', 'text/html');
        $this->response->getBody()->write($body);
    }

    protected function success($payload)
    {
        $this->response = $this->response->withStatus(200);
        if ('application/json' === $this->request->getHeaderLine('Accept')) {
            $this->jsonBody($payload);
        } else {
            $this->htmlBody($payload);
        }
    }

    protected function error($payload)
    {
        $this->response = $this->response->withStatus(500);
        $this->request = $this->request->withAttribute('_view', 'error.html.twig');
        $this->htmlBody($payload);
    }
}
