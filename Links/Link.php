<?php
namespace MesClics\UtilsBundle\Links;

use MesClics\EspaceClientBundle\Entity\Image;

class Link{
    private $name;
    private $url;
    private $short_url;

    public function setName(string $name){
        $this->name = $name;
    }

    public function getName(){
        return $this->name;
    }

    public function setUrl(string $url){
        $this->$url = $url;
    }

    public function getUrl(){
        return $this->url;
    }

    public function setShortUrl(string $url){
        $this->short_url = $url;
    }

    public function getShortUrl(){
        return $this->short_url;
    }
}