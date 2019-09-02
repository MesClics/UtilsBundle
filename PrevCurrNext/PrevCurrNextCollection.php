<?php

namespace MesClics\UtilsBundle\PrevCurrNext;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

class PrevCurrNextCollection extends ArrayCollection{
    private $prev;
    private $curr;
    private $next;


    public function setPrev($item){
        return $this->prev;
    }

    public function getPrev(){
        if(!$this->prev){
            if(!$this->getCurr()){
                return $this->getBeforeLast();
            }
        }

        return $this->prev;
    }

    public function setCurr($item){
        $this->curr = $item;

        return $this;
    }

    public function getCurr(){
        return $this->curr;
    }

    public function setNext($item){
        $this->next = $item;

        return $this;
    }

    public function getNext(){
        return $this->next;
    }

    public function next(){
        return $this->next;
    }

    public function getBeforeLast(){
        $before_last = current($this->slice(-2, 1));
        return $before_last;
    }

    public function setPrevCurrNext($current){
        if(!$current){
           return;
        }

        // set curr
        $this->curr = $current;

        $hasHigherIdThanCurr = function($k, $item){
            if($item->getId() > $this->curr->getId()){
                return $item;
            }
        };
        
        $isNotSameAsCurrent = function($k, $item){
            if($item !== $this->curr){
                return $item;
            }
        };

        //split the visitedRoutes collection in 2 collections at the current route
        $partition = $this->partition($isNotSameAsCurrent)[0]->partition($hasHigherIdThanCurr);
        !empty($partition[1]) ? $this->prev = $partition[1]->last() : null;
        !empty($partition[0]) ? $this->next = $partition[0]->first() : null;        
    }
}