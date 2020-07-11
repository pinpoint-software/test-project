<?php
namespace Application\Service;

use Application\Domain\Gateway\LinkReadOnly;

class TextPost
{
    private $linkGateway;

    public function __construct(LinkReadOnly $linkGateway)
    {
        $this->linkGateway = $linkGateway;
    }

    public function __invoke($id)
    {
        $post = $this->linkGateway->getLinkById($id);

        $payload = [
            'success' => true,
        ];

		$payload['post'] = [
			'title' => $post->title(),
			'url' => $post->url(),
			'text' => $post->text(),
			'id' => $post->id(),
			'firstName' => $post->submitter()->firstName(),
			'lastName' => $post->submitter()->lastName(),
			'created' => $post->created(),
		];

        return $payload;
    }
}
