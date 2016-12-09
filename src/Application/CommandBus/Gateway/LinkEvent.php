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

    public function submit($title, $url, $submitterId)
    {
        $created = new DateTime('now', new DateTimeZone('UTC'));

        $this->commandBus->handle(new SubmitLink(
            $title,
            $url,
            $submitterId,
            $created->format('Y-m-d H:i:s')
        ));
    }
}
