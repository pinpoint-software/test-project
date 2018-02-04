<?php
namespace Application\Service;

use Application\Domain\Gateway\TextEvent;

class TextSubmit
{
    private $textGateway;

    public function __construct(TextEvent $textGateway)
    {
        $this->textGateway = $textGateway;
    }

    public function __invoke($title, $text, $submitterId)
    {
        if (empty($submitterId)) {
            $payload = [
                'success' => false,
                'warning' => 'Must be logged in to submit texts',
            ];
        } elseif (empty($title) || empty($text)) {
            $payload = [
                'success' => false,
                'warning' => 'Title and Text are required',
            ];
        } else {
            $payload = [
                'success' => true,
            ];
            $this->textGateway->submit($title, $text, $submitterId);
        }

        return $payload;
    }
}
