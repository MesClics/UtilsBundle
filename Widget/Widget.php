<?php

namespace MesClics\UtilsBundle\Widget;

use Symfony\Component\HttpFoundation\Request;
abstract class Widget{
    protected $handler;
    protected $class;
    protected $title;

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

    public function addClass(string $class){
        $toArray = explode(" ", $this->class);
        $toArray[] = $class;
        $this->class = implode(" ", $toArray);

        return $this;
    }

    public function addClasses(array $classes){
        foreach($classes as $class){
            $this->addClass($class);
        }
    }

    public function setClass(string $class){
        $this->class = $class;

        return $this;
    }

    public function getClass(){
        return $this->class;
    }

    public function setTitle(string $title){
        $this->title = $title;

        return $this;
    }

    public function getTitle(){
        return $this->title;
    }

    public function addVariable(string $name, $value){
        $this->variables[$name] = $value;

        return $this;
    }
    
    abstract public function getName();
    abstract public function getTemplate();
    abstract public function getVariables();
}