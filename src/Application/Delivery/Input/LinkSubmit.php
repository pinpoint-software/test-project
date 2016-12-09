<?php
namespace Application\Delivery\Input;

use Psr\Http\Message\ServerRequestInterface as Request;

class LinkSubmit
{
    public function __invoke(Request $request)
    {
        $post = $request->getParsedBody();
        $user = $request->getAttribute('user', false);
        $submitterId = (false === $user ? false : $user['id']);
        return [$post['title'], $post['url'], $submitterId];
    }
}
