<?php
namespace MesClics\UtilsBundle\Widget;

use Symfony\Component\HttpFoundation\Request;

abstract class WidgetsContainer{
    protected $widgets;

    abstract function initialize($params = array());


    public function __construct(){
        $this->widgets = array();
    }

    public function handleRequest(Request $request){
        $widgets = $this->getWidgets();
        foreach($widgets as $widget){
            if($widget->getHandler()){
                $res = $widget->getHandler()->handleRequest($widget, $request);
                if($res){
                    return $res;
                }
            }
        }
    }

    public function addWidget(Widget $widget){
        $this->widgets[] = $widget;
        return $this;
    }

    public function getWidgets(){
        return $this->widgets;
    }

    public function getWidget(string $name){
        foreach($this->widgets as $widget){
            if($widget->getName() === $name){
                return $widget;
            }
        }
        return null;
    }
}