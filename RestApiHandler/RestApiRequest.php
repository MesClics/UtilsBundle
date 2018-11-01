<?php
namespace MesClics\UtilsBundle\RestApiHandler;

abstract class RestApiRequest{
    private $headers;
    private $method;
    private $data;
    private $endpoint_path;
    
    public function __construct($options){
        if($options['headers']){ $this->headers = $options['headers']; }
        if($options['method']){ $this->headers = $options['method']; }
        if($options['data']){ $this->headers = $options['data']; }
        if($options['path']){ $this->headers = $options['endpoint_path']; }
    }

    public function getEndPointPath(){
        return $this->endpoint_path;
    }
}