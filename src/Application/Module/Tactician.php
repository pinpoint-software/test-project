<?php
namespace Application\Module;

use Application\CommandBus\ContainerLocator;
use Application\CommandBus\Listener\SubmitLink as SubmitLinkListener;
use Application\CommandBus\Listener\SubmitText as SubmitTextListener;
use Application\Domain\Event\SubmitLink as SubmitLinkEvent;
use Application\Domain\Event\SubmitText as SubmitTextEvent;
use Aura\Di\Container;
use Cadre\Module\Module;
use League\Tactician\CommandBus;
use League\Tactician\Handler\CommandHandlerMiddleware;
use League\Tactician\Handler\CommandNameExtractor\ClassNameExtractor;
use League\Tactician\Handler\MethodNameInflector\InvokeInflector;
use League\Tactician\Plugins\LockingMiddleware;

class Tactician extends Module
{
    public function define(Container $di)
    {
        $di->set(SubmitLinkListener::class, $di->lazyNew(SubmitLinkListener::class));
        $di->set(SubmitTextListener::class, $di->lazyNew(SubmitTextListener::class));

        $di->params[CommandBus::class] = [
            'middleware' => $di->lazyArray([
                $di->lazyNew(LockingMiddleware::class),
                $di->lazyNew(CommandHandlerMiddleware::class),
            ]),
        ];

        $di->params[CommandHandlerMiddleware::class] = [
            'commandNameExtractor' => $di->lazyNew(ClassNameExtractor::class),
            'handlerLocator' => $di->lazyNew(ContainerLocator::class),
            'methodNameInflector' => $di->lazyNew(InvokeInflector::class),
        ];

        $di->params[ContainerLocator::class] = [
            'container' => $di,
            'commandNameToHandlerMap' => [
                SubmitLinkEvent::class => SubmitLinkListener::class,
                SubmitTextEvent::class => SubmitTextListener::class
            ],
        ];
    }
}
