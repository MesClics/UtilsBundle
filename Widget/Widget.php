<?php

namespace MesClics\UtilsBundle\Widget;

use Symfony\Component\HttpFoundation\Request;
abstract class Widget{
    protected $handler;

    protected function createForm($type, $data = null, $options = array()){
        return $this->handler->form_factory->create($type, $data, $options);
    }

    public function getHandler(){
        return $this->handler;
    }

    protected function handleRequest(Request $request){
        if($widget->getHandler()){
            $widget->getHandler()->handleRequest($this, $request);
        }
    }
    
    abstract public function getName();
    abstract public function getTemplate();
    abstract public function getVariables();
}