<?php
namespace Application\CommandBus\Gateway;

use Application\Domain\Event\SubmitLink;
use Application\Domain\Gateway\LinkEvent as LinkEventInterface;
use DateTime;
use DateTimeZone;
use League\Tactician\CommandBus;

class LinkEvent implements LinkEventInterface
{
    private $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function submit($title, $url, $submitterId, $userText, $dblLink)
    {
        $created = new DateTime('now', new DateTimeZone('UTC'));
        // if the user proivded both a url and some text and wants both links
        // created, create the URL link first
        if($dblLink) {
            $this->commandBus->handle(new SubmitLink(
                $title,
                $url,
                $submitterId,
                $created->format('Y-m-d H:i:s'),
                ""
            ));
        }

        // now create the text link
        // (or the text/url link if this post is only creating a single link)
        $this->commandBus->handle(new SubmitLink(
            $title,
            $url,
            $submitterId,
            $created->format('Y-m-d H:i:s'),
            $userText
        ));
    }
}
