<?php
namespace Application\CommandBus\Gateway;

use Application\Domain\Event\SubmitText;
use Application\Domain\Gateway\TextEvent as TextEventInterface;
use DateTime;
use DateTimeZone;
use League\Tactician\CommandBus;

class TextEvent implements TextEventInterface
{
    private $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function submit($title, $text, $submitterId)
    {
        $created = new DateTime('now', new DateTimeZone('UTC'));

        $this->commandBus->handle(new SubmitText(
            $title,
            $text,
            $submitterId,
            $created->format('Y-m-d H:i:s')
        ));
    }
}
