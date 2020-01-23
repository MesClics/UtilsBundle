<?php

namespace MesClics\UtilsBundle\Widget;

use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormFactoryInterface;
use MesClics\UtilsBundle\Widget\Handler\WidgetHandler;
use Symfony\Component\EventDispatcher\EventDispatcher;

abstract class Widget{
    protected $handler;

    protected function createForm($type, $data = null, $options = array()){
        return $this->handler->form_factory->create($type, $data, $options);
    }

    public function getHandler(){
        return $this->handler;
    }
    
    abstract public function getName();
    abstract public function getTemplate();
    abstract public function getVariables();
}