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

    public function __invoke()
    {
        $text = $this->textGateway->getText();

        $payload['success'] = 'true';
        $payload['text'] = [
          'id' => $text->id(),
          'title' => $text->title(),
          'text' => $text->text(),
          'firstName' => $text->submitter()->firstName(),
          'lastName' => $text->submitter()->lastName(),
          'created' => $text->created(),
        ];

        return $payload;
    }
}
