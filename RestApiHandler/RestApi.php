<?php

namespace MesClics\UtilsBundle\RestApiHandler;

abstract class RestApi{
    private $version;
    private $endpoint_root;

    public function __construct($options){
        if($options['version']){ $this->version = $options['version']; }
        if($options['endpoint_root']){
             $this->endpoint_root = $options['endpoint_root'];
        }
    }
}