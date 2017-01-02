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
        } elseif (empty($title) || empty($url)) {
            $payload = [
                'success' => false,
                'warning' => 'Title and URL are required',
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
