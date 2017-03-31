<?php
namespace Application\Delivery\Input;

use Psr\Http\Message\ServerRequestInterface as Request;

class LinkText
{
    public function __invoke(Request $request)
    {
        return $request->getAttribute('id');
    }
}
