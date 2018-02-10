<?php
namespace Application\Service;

use Application\Domain\Gateway\LinkEvent;

class LinkSubmit
{
    private $linkGateway;

    public function __construct(LinkEvent $linkGateway)
    {
        $this->linkGateway = $linkGateway;
    }

    public function __invoke($title, $url, $text, $submitterId)
    {
        if (empty($submitterId)) {
            $payload = [
                'success' => false,
                'warning' => 'Must be logged in to submit links',
            ];
        } elseif ( $url && $text ) {
            $payload = [
                'success' => false,
                'warning' => 'Submissions can\'t have both urls and text, so you need to pick one. ☝️ ',
            ];
        } elseif ( empty($title) || ( empty($url) && empty($text) ) ) {
            $payload = [
                'success' => false,
                'warning' => 'Title and URL OR Text are required',
            ];
        } else {
            $payload = [
                'success' => true,
            ];
            $this->linkGateway->submit($title, $url, $text, $submitterId);
        }

        return $payload;
    }
}
