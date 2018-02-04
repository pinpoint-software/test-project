<?php
namespace Application\Delivery\Input;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr7Middlewares\Middleware\AuraSession;

class TextViewer
{
    public function __invoke(Request $request)
    {
        return [];
    }
}
