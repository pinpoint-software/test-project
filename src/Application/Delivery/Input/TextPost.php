<?php
namespace Application\Delivery\Input;

use Psr\Http\Message\ServerRequestInterface as Request;

class TextPost
{
    public function __invoke(Request $request)
    {
        $post = $request->getQueryParams();
        return [$post['id']];
    }
}
