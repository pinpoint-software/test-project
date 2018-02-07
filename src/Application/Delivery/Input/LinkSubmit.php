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
        $ret = [$post['title'], $post['url'], $submitterId, $post['userText']];
        // if the user did not click the 'Create Both Links' button, the
        // 'dbl-link-btn' index will not exist...so handle accordingly
        if (array_key_exists('dbl-link-btn', $post)) {
            $ret[] = $post['dbl-link-btn'];
        }
        return $ret;
    }
}
