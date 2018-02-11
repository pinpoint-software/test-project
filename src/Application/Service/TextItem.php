<?php
namespace Application\Service;

use Application\Domain\Gateway\TextReadOnly;

class TextItem
{
    private $linkGateway;

    public function __construct(TextReadOnly $linkGateway)
    {
        $this->linkGateway = $linkGateway;
    }

    public function __invoke()
    {
        $links = $this->linkGateway->getRecentLinks();

        $payload = [
            'success' => true,
            'text' => [],
        ];

        $payload['text'][] = [
                // 'title' => $link->title(),
                'title' => 'This is the title',
                // 'content' => $link->text(),
                'content' => 'And some text...',
                // 'firstName' => $link->submitter()->firstName(),
                // 'lastName' => $link->submitter()->lastName(),
                // 'created' => $link->created(),
            ];
        }

        return $payload;
    }
}
