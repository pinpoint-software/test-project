<?php
namespace Application\Module;

use Application\AtlasOrm\Gateway\LinkWrite;
use Application\CommandBus\Gateway\LinkEvent;
use Application\CommandBus\Listener\SubmitLink as SubmitLinkListener;
use Application\Domain\Event\SubmitLink as SubmitLinkEvent;
use Application\AtlasOrm\Gateway\TextWrite;
use Application\CommandBus\Gateway\TextEvent;
use Application\CommandBus\Listener\SubmitText as SubmitTextListener;
use Application\Domain\Event\SubmitText as SubmitTextEvent;
use Aura\Di\Container;
use Cadre\Module\Module;
use League\Tactician\CommandBus;

class Domain extends Module
{
    public function define(Container $di)
    {
        $di->params[LinkEvent::class] = [
            'commandBus' => $di->lazyNew(CommandBus::class),
        ];

        $di->params[SubmitLinkListener::class] = [
            'linkGateway' => $di->lazyNew(LinkWrite::class),
        ];

        $di->params[TextEvent::class] = [
            'commandBus' => $di->lazyNew(CommandBus::class),
        ];

        $di->params[SubmitTextListener::class] = [
            'textGateway' => $di->lazyNew(TextWrite::class),
        ];
    }

    public function modify(Container $di)
    {
    }
}
