<?php
namespace Application\Delivery\Input;

use Psr\Http\Message\ServerRequestInterface as Request;

class Generic
{
    public function __invoke(Request $request)
    {
        return [];
    }
}
