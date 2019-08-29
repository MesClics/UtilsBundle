<?php
namespace MesClics\UtilsBundle\ApisManager;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\OptionsResolver\Exception\InvalidArgumentException;

class ApisManager{
    private $apis;

    public function __construct($apisClasses, SessionInterface $session){
        $this->apis = new ArrayCollection();
        foreach($apisClasses as $name => $class){
            $class_full = $class['class'];
            
            $api = new $class_full($class['options'], $session);
            $this->apis->add($api);
        }
    }

    public function getApi($name){
        $api = null;
        foreach($this->apis as $api_obj){
            if($api_obj->getName() === $name){
                $api = $api_obj;
                break;
            }
        }

        if(!isset($api)){
            throw new InvalidArgumentException("Aucune api " . $name . " n'est gérée par l'ApiManager.");
        }

        return $api;
    }
}
