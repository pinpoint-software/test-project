<?php
namespace Application\Service;

use Application\Domain\Gateway\TextReadOnly;

class LinkText
{
    private $textGateway;

    public function __construct(TextReadOnly $textGateway)
    {
        $this->textGateway = $textGateway;
    }

    public function __invoke($id)
    {
        $link = $this->textGateway->getLink($id);

        $payload = [
            'success' => true,
            'link' => [
                'id' => $link->id(),
                'title' => $link->title(),
                'url' => $link->url(),
                'text' => $link->text(),
                'firstName' => $link->submitter()->firstName(),
                'lastName' => $link->submitter()->lastName(),
                'created' => $link->created(),
            ],
        ];

        return $payload;
    }
}
