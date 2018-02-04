<?php
namespace Application\Module;

use Application\AtlasOrm\Gateway\LinkReadOnly;
use Application\AtlasOrm\Gateway\TextReadOnly;
use Application\AtlasOrm\Gateway\UserReadOnly;
use Application\CommandBus\Gateway\LinkEvent;
use Application\CommandBus\Gateway\TextEvent;
use Aura\Di\Container;
use Cadre\Module\Module;
use Application\Delivery\Input;
use Application\Delivery\Responder;
use Application\Service;

class Routing extends Module
{
    public function define(Container $di)
    {
        $di->params[Service\SubmissionList::class] = [
            'linkGateway' => $di->lazyNew(LinkReadOnly::class),
            'textGateway' => $di->lazyNew(TextReadOnly::class)
        ];

        $di->params[Service\LinkSubmit::class] = [
            'linkGateway' => $di->lazyNew(LinkEvent::class),
        ];

        $di->params[Service\TextSubmit::class] = [
          'textGateway' => $di->lazyNew(TextEvent::class)
        ];

        $di->params[Service\LoginSubmit::class] = [
            'userGateway' => $di->lazyNew(UserReadOnly::class),
        ];

        $di->params[Service\TextViewer::class] = [
            'textGateway' => $di->lazyNew(TextReadOnly::class)
        ];
    }

    public function modify(Container $di)
    {
        $adr = $di->get('radar/adr:adr');

        $adr->get('ListPosts', '/', Service\SubmissionList::class)
            ->defaults(['_view' => 'list.html.twig']);

        $adr->get('ListSpecific', '/list/', Service\SubmissionList::class)
            ->defaults(['_view' => 'list.html.twig']);

        $adr->get('ListTexts', '/list/texts/', Service\SubmissionList::class)
            ->defaults(['_view' => 'listtext.html.twig']);

        $adr->get('ListLinks', '/list/links/', Service\SubmissionList::class)
            ->defaults(['_view' => 'listlink.html.twig']);

        $adr->get('LoginForm', '/login/', Service\LoginForm::class)
            ->input(Input\LoginForm::class)
            ->defaults(['_view' => 'login.html.twig']);

        $adr->post('LoginSubmit', '/login/', Service\LoginSubmit::class)
            ->input(Input\LoginSubmit::class)
            ->responder(Responder\LoginSubmit::class);

        $adr->get('Logout', '/logout/', Service\Generic::class)
            ->responder(Responder\Logout::class);

        $adr->get('SubmissionFormLink', '/submit/link/', Service\SubmissionForm::class)
            ->input(Input\SubmissionForm::class)
            ->defaults(['_view' => 'link.html.twig']);

        $adr->get('SubmissionFormText', '/submit/text/', Service\SubmissionForm::class)
            ->input(Input\SubmissionForm::class)
            ->defaults(['_view' => 'text.html.twig']);

        $adr->post('LinkSubmit', '/submit/link/', Service\LinkSubmit::class)
            ->input(Input\LinkSubmit::class)
            ->responder(Responder\GenericRedirect::class);

        $adr->post('TextSubmit', '/submit/text/', Service\TextSubmit::class)
            ->input(Input\TextSubmit::class)
            ->responder(Responder\GenericRedirect::class);

        $adr->get('TextView', '/text/{id}/', Service\TextViewer::class)
            ->input(Input\TextView::class)
            ->defaults(['_view' => 'viewtext.html.twig']);
    }
}
