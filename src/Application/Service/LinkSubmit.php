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

    public function __invoke($title, $url, $submitterId, $userText, $dblLink)
    {
        if (empty($submitterId)) {
            $payload = [
                'success' => false,
                'warning' => 'Must be logged in to submit links',
            ];
        } elseif (empty($title)) {
            $payload = [
                'success' => false,
                'warning' => 'A Title is required',
            ];
        } elseif (empty($url) && empty($userText)) {
            $payload = [
                'success' => false,
                'warning' => 'Either a URL or a text description to be linked must be provided',
            ];
        } else {
            $payload = [
                'success' => true,
            ];
            $this->linkGateway->submit($title, $url, $submitterId, $userText, $dblLink);
        }

        return $payload;
    }
}
