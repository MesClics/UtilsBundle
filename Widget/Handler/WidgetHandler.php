<?php

namespace MesClics\UtilsBundle\Widget\Handler;

use MesClics\UtilsBundle\Widget\Widget;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

abstract class WidgetHandler{
    public $form_factory;
    public $entity_manager;
    public $event_dispatcher;
    
    public function __construct(FormFactoryInterface $form_factory, EntityManagerInterface $entity_manager, EventDispatcherInterface $event_dispatcher){
        $this->form_factory = $form_factory;
        $this->entity_manager = $entity_manager;
        $this->event_dispatcher = $event_dispatcher;
    }

    abstract function handleRequest(Widget $widget, Request $request);
}