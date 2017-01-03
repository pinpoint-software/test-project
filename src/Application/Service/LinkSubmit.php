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
        } elseif (empty($title)) {
            $payload = [
                'success' => false,
                'warning' => 'Title is required',
            ];
        } elseif (empty($text) && empty($url)) {
            $payload = [
                'success' => false,
                'warning' => 'URL or Description is required',
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
