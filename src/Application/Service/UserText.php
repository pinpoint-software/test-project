<?php
namespace Application\Service;

use Application\Domain\Gateway\LinkReadOnly;

class UserText
{

    private $linkGateway;

    public function __construct(LinkReadOnly $linkGateway)
    {
        $this->linkGateway = $linkGateway;
    }

    public function __invoke()
    {
        $title = urldecode(rtrim(substr($_SERVER['REQUEST_URI'], 6), '/'));
        $record = $this->linkGateway->getLinkByTitle($title);
        $userText = $record->userText;
        if($userText) {
            $payload = [
                'success' => true,
                'text' => $userText,
                'title' => $title,
            ];
        } else {
            $payload = [
                'success' => false,
                'warning' => "Could not find requested link record.",
            ];

        }

        return $payload;
    }

}
