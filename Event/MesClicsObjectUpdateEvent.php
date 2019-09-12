<?php

namespace MesClics\UtilsBundle\Event;

use Symfony\Component\EventDispatcher\Event;

abstract class MesClicsObjectUpdateEvent extends Event{

    protected $before_update;
    protected $after_update;

    public function __construct($before_update, $after_update){
        $this->before_update = $before_update;
        $this->after_update = $after_update;
    }

    public function hasChanged(string $property){
        $method = $this->getMethod($property, $this);
        
        if($method){
            if($this->before_update->$method() !== $this->after_update->$method()){
                return array($this->before_update->$method(), $this->after_update->$method());
            }
        }

        return false;
    }

    public function getBeforeUpdate(){
        return $this->before_update;
    }

    public function getAfterUpdate(){
        return $this->after_update;
    }

    protected function getMethod(string $property){
        $suffix = str_replace("_", "", ucwords($property, "_"));
        switch($property){
            case method_exists($this->getAfterUpdate(), "get".$suffix):
            return "get".$suffix;
            break;

            case  method_exists($this->getAfterUpdate(), "has".$suffix):
            return "has".$suffix;
            break;

            case  method_exists($this->getAfterUpdate(), "is".$suffix):
            return "is".$suffix;
            break;

            case method_exists($this->getAfterUpdate(), $suffix):
            return $suffix;

            default :
            return false;
            break;
        }
    }
}