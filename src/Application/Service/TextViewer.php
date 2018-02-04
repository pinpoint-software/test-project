<?php
namespace Application\Service;

use Application\Domain\Gateway\TextReadOnly;

class TextViewer
{
    private $textGateway;

    public function __construct(TextReadOnly $textGateway)
    {
        $this->textGateway = $textGateway;
    }

    public function __invoke($id)
    {
        $text = $this->textGateway->getText($id);

        $payload = [
            'success' => true,
            'post' => [
              'title' => $text->title,
              'text' => $text->text
            ]
        ];

        return $payload;
    }
}
