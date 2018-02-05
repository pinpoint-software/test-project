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
        parse_str($_SERVER['QUERY_STRING'], $query);
        $id = $query['id'];
        if ($id) {
            $record = $this->linkGateway->getLinkById($id);
        } else {
            $payload = [
                'success' => false,
                'warning' => "Invlaid query string.",
            ];
            return $payload;
        }

        $userText = $record->userText;
        if($userText) {
            $payload = [
                'success' => true,
                'text' => $userText,
                'title' => $record->title,
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
