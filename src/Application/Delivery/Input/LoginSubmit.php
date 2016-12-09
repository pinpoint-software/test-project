<?php
namespace Application\Delivery\Input;

use Psr\Http\Message\ServerRequestInterface as Request;

class LoginSubmit
{
    public function __invoke(Request $request)
    {
        $post = $request->getParsedBody();
        return [$post['email'], $post['password']];
    }
}
