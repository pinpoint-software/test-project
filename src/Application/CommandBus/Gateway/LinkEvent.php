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
        // if the user proivded a url and wants a second link created
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
        // (or the url link...if this is just a plain old url post)
        $this->commandBus->handle(new SubmitLink(
            $title,
            $url,
            $submitterId,
            $created->format('Y-m-d H:i:s'),
            $userText
        ));
    }
}
