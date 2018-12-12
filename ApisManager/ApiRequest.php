<?php
namespace MesClics\UtilsBundle\ApisManager\RestApis;

class ApiRequest{
    private $headers;
    private $query;
    private $endpoint;
    private $options;
    private $method;
    private $response;

    public function __construct($method){
        $this->method = $method;
        $this->response = false;
    }

    public function addHeader(string $name, $value){
        $this->headers[$name] = $value;
        return $this;
    }

    public function removeHeader(string $name){
        unset($this->headers[$name]);
        return $this;
    }

    public function getHeaders(){
        return $this->headers;
    }

    public function addQueryAttr(string $attr_name, $attr_value){
        $this->query[$attr_name] = $attr_value;
        return $this;
    }

    public function removeQueryAttr(string $attr_name){
        unset($this->query[$attr_name]);
        return $this;
    }

    public function getQuery(){
        return $this->query;
    }

    public function setEndpoint(string $endpoint){
        $this->endpoint = $endpoint;
    }

    public function getEndpoint(){
        return $this->endpoint;
    }

    public function addOption($name, $value){
        $this->options[$name] = $value;
        return $this;
    }

    public function removeOption($name){
        unset($this->options[$name]);
    }

    public function getOptions(){
        return $this->options;
    }

    public function getMethod(){
        return $this->method;
    }

    public function setResponse($response){
        $this->response = $response;
    }
}