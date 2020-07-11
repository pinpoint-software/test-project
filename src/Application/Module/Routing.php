<?php
namespace Application\Module;

use Application\AtlasOrm\Gateway\LinkReadOnly;
use Application\AtlasOrm\Gateway\UserReadOnly;
use Application\CommandBus\Gateway\LinkEvent;
use Aura\Di\Container;
use Cadre\Module\Module;
use Application\Delivery\Input;
use Application\Delivery\Responder;
use Application\Service;

class Routing extends Module
{
    public function define(Container $di)
    {
        $di->params[Service\LinkList::class] = [
            'linkGateway' => $di->lazyNew(LinkReadOnly::class),
        ];

        $di->params[Service\LinkSubmit::class] = [
            'linkGateway' => $di->lazyNew(LinkEvent::class),
        ];

        $di->params[Service\LoginSubmit::class] = [
            'userGateway' => $di->lazyNew(UserReadOnly::class),
        ];
		
		$di->params[Service\TextPost::class] = [
            'linkGateway' => $di->lazyNew(LinkReadOnly::class),
        ];
    }

    public function modify(Container $di)
    {
        $adr = $di->get('radar/adr:adr');

        $adr->get('ListLinks', '/', Service\LinkList::class)
            ->defaults(['_view' => 'list.html.twig']);

        $adr->get('LoginForm', '/login/', Service\LoginForm::class)
            ->input(Input\LoginForm::class)
            ->defaults(['_view' => 'login.html.twig']);

        $adr->post('LoginSubmit', '/login/', Service\LoginSubmit::class)
            ->input(Input\LoginSubmit::class)
            ->responder(Responder\LoginSubmit::class);

        $adr->get('Logout', '/logout/', Service\Generic::class)
            ->responder(Responder\Logout::class);

        $adr->get('LinkForm', '/submit/', Service\LinkForm::class)
            ->input(Input\LinkForm::class)
            ->defaults(['_view' => 'link.html.twig']);

        $adr->post('LinkSubmit', '/submit/', Service\LinkSubmit::class)
            ->input(Input\LinkSubmit::class)
            ->responder(Responder\GenericRedirect::class);
			
		$adr->get('TextPost', '/post/', Service\TextPost::class)
			->input(Input\TextPost::class)
            ->defaults(['_view' => 'textpost.html.twig']);
    }
}
