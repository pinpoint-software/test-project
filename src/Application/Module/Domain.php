<?php
namespace Application\Module;

use Application\AtlasOrm\Gateway\LinkWrite;
use Application\Dispatcher\Gateway\LinkEvent;
use Application\Dispatcher\Listener\SubmitLink as SubmitLinkListener;
use Application\Domain\Event\SubmitLink as SubmitLinkEvent;
use Aura\Di\Container;
use Cadre\Dispatcher\MemoryDispatcher;
use Cadre\Module\Module;
use Application\Service\Login\Submit;

class Domain extends Module
{
    public function define(Container $di)
    {
        $di->params[LinkEvent::class] = [
            'dispatcher' => $di->lazyNew(MemoryDispatcher::class),
        ];

        $di->setters[MemoryDispatcher::class] = [
            'addMultiple' => $di->lazyArray([
                $di->lazyArray([
                    'class' => SubmitLinkEvent::class,
                    'listener' => $di->lazyNew(SubmitLinkListener::class),
                ]),
            ]),
        ];

        $di->params[SubmitLinkListener::class] = [
            'linkGateway' => $di->lazyNew(LinkWrite::class),
        ];
    }

    public function modify(Container $di)
    {
    }
}
