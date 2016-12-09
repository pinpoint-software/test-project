<?php
namespace Application\Dispatcher\Gateway;

use Application\Domain\Event\SubmitLink;
use Application\Domain\Gateway\LinkEvent as LinkEventInterface;
use Cadre\Dispatcher\Dispatcher;
use DateTime;
use DateTimeZone;

class LinkEvent implements LinkEventInterface
{
    private $dispatcher;

    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function submit($title, $url, $submitterId)
    {
        $created = new DateTime('now', new DateTimeZone('UTC'));

        $this->dispatcher->dispatch(new SubmitLink(
            $title,
            $url,
            $submitterId,
            $created->format('Y-m-d H:i:s')
        ));
    }
}
