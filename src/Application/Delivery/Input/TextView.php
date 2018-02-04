<?php
namespace Application\Delivery\Input;

use Psr\Http\Message\ServerRequestInterface as Request;

class TextView
{
    public function __invoke(Request $request)
    {
        $id = $request->getAttribute('id');

        return ['id' => $id];
    }
}
