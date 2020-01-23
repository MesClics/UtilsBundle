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
            $widget->getHandler()->handleRequest($widget, $request);
        }
    }

    public function addWidget(Widget $widget){
        $this->widgets[] = $widget;
    }

    public function getWidgets(){
        return $this->widgets;
    }
}