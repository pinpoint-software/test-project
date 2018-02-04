<?php
namespace Application\Service;

use Application\Domain\Gateway\LinkReadOnly;
use Application\Domain\Gateway\TextReadOnly;

class SubmissionList
{
    private $linkGateway;
    private $textGateway;

    public function __construct(LinkReadOnly $linkGateway, TextReadOnly $textGateway)
    {
        $this->linkGateway = $linkGateway;
        $this->textGateway = $textGateway;
    }

    public function __invoke()
    {
        $links = $this->linkGateway->getRecentLinks();
        $texts = $this->textGateway->getRecentTexts();

        $payload = [
            'success' => true,
            'links' => [],
            'texts' => [],
            'posts' => []
        ];

        foreach ($links as $link) {
            $payload['links'][] = [
                'title' => $link->title(),
                'url' => $link->url(),
                'firstName' => $link->submitter()->firstName(),
                'lastName' => $link->submitter()->lastName(),
                'created' => $link->created(),
            ];
        }

        foreach ($texts as $text) {
          $payload['texts'][] = [
            'id' => $text->id(),
            'title' => $text->title(),
            'text' => $text->text(),
            'firstName' => $text->submitter()->firstName(),
            'lastName' => $text->submitter()->lastName(),
            'created' => $text->created(),
          ];
        }

        $merged = array_merge($payload['links'], $payload['texts']);
        usort($merged, function($d1, $d2) {
          return ($d1['created']->getTimestamp() > $d2['created']->getTimestamp()) ? -1 : 1;
        });

        $payload['posts'] = $merged;

        return $payload;
    }
}
