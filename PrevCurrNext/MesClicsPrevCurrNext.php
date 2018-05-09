<?php
namespace MesClics\UtilsBundle\PrevCurrNext;

class MesClicsPrevCurrNext{
    private $results = null;
    private $current = null;
    private $previous = null;
    private $next = null;
    private $desc = null;

    public function handle($current, $results, $desc = false){
        $this->desc = $desc;
        $this->results = $results;
        $this->current = $current;
        $this->setNext();
        $this->setPrevious();

        return $this;
    }

    private function setNext(){
        foreach($this->results as $k => $v){
            if($v === $this->current){
                if(isset($this->results[($k + 1)])){
                    $this->next = $this->results[($k + 1)];
                }
            }
        }
    }

    private function setPrevious(){
        foreach($this->results as $k => $v){
            if($v === $this->current){
                if(isset($this->results[($k - 1)])){
                    $this->previous = $this->results[$k - 1];
                }
            }
        }
    }

    public function getNext(){
        if(!$this->desc){
            return $this->next;
        } else{
            return $this->previous;
        }
    }

    public function getCurrent(){
        return $this->current;
    }

    public function getPrevious($desc = false){
        if(!$this->desc){
            return $this->previous;
        } else{
            return $this->next;
        }
    }
}