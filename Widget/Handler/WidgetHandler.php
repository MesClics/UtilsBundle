<?php

namespace MesClics\UtilsBundle\Widget\Handler;

use MesClics\UtilsBundle\Widget\Widget;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

abstract class WidgetHandler{
    public $form_factory;
    public $entity_manager;
    public $event_dispatcher;
    public $router;
    
    public function __construct(FormFactoryInterface $form_factory, EntityManagerInterface $entity_manager, EventDispatcherInterface $event_dispatcher, RouterInterface $router){
        $this->form_factory = $form_factory;
        $this->entity_manager = $entity_manager;
        $this->event_dispatcher = $event_dispatcher;
        $this->router = $router;
    }

    public function redirectToRoute($route, $args){
        return new RedirectResponse($this->router->generate($route, $args));
    }

    abstract function handleRequest(Widget $widget, Request $request);
}