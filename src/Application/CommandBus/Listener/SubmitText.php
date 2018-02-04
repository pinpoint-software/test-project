<?php
namespace Application\CommandBus\Listener;

use Application\Domain\Event\SubmitText as SubmitTextEvent;
use Application\Domain\Gateway\TextWrite;
use DateTime;
use DateTimeZone;

class SubmitText
{
    private $textGateway;

    public function __construct(TextWrite $textGateway)
    {
        $this->textGateway = $textGateway;
    }

    public function __invoke(SubmitTextEvent $event)
    {
        $this->textGateway->create(
            $event->title(),
            $event->text(),
            $event->submitterId(),
            new DateTime($event->created(), new DateTimeZone('UTC'))
        );
    }
}
