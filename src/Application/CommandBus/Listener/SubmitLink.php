<?php
namespace Application\CommandBus\Listener;

use Application\Domain\Event\SubmitLink as SubmitLinkEvent;
use Application\Domain\Gateway\LinkWrite;
use DateTime;
use DateTimeZone;

class SubmitLink
{
    private $linkGateway;

    public function __construct(LinkWrite $linkGateway)
    {
        $this->linkGateway = $linkGateway;
    }

    public function __invoke(SubmitLinkEvent $event)
    {
        $this->linkGateway->create(
            $event->title(),
            $event->url(),
			$event->text(),
            $event->submitterId(),
            new DateTime($event->created(), new DateTimeZone('UTC'))
        );
    }
}
