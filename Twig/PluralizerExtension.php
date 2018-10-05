<?php

namespace MesClics\UtilsBundle\Twig;
use MesClics\UtilsBundle\Pluralizer\MesClicsPluralizer;

class PluralizerExtension extends \Twig_Extension{
    private $pluralizer;

    public function __construct(MesClicsPluralizer $pluralizer){
        $this->pluralizer = $pluralizer;
    }

    public function pluralize($singular, $plural, $var_more_than_one){
       return $this->pluralizer->pluralize($singular, $plural, $var_more_than_one);
    }

    public function getFunctions(){
        return array(
            new \Twig_SimpleFunction('pluralize', array($this, 'pluralize'))
        );
    }

    public function getName(){
        return 'MesClicsPluralizer';
    }
}