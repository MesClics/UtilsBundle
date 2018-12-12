<?php

namespace MesClics\UtilsBundle\ApisManager\RestApis;

use Doctrine\Common\Collections\ArrayCollection;
use MesClics\UtilsBundle\Functions\MesClicsFunctions;
use Symfony\Component\HttpFoundation\Session\Session;
use MesClics\UtilsBundle\ApisManager\RestApis\ApiRequest;
use Unirest\Request as UnirestRequest;

abstract class RestApi{
    protected $name;
    protected $version;
    protected $endpoint_root;
    protected $api_key;
    protected $token;
    // TODO: ajouter le système de cache
    // protected $cache;

    public function __construct(Array $options = null, Session $session){
        if($options['name']){ $this->name = $options['name']; }
        if($options['version']){ $this->version = $options['version']; }
        if($options['endpoint_root']){
             $this->endpoint_root = $options['endpoint_root'];
        }
        if($options['api_key']){ $this->api_key = $options['api_key']; }

        if($options['dev_token']){ $this->token = $options['dev_token']; }
        elseif($options['token']){ $this->token = $options['token']; }
    }

    public function setName($name){
        $this->name = $name;
        return $this;
    }

    public function getName(){
        return $this->name;
    }

    /**
     * Get endpoint
     * 
     * @return endpoint_root/version/
     * ex: api.google.com/1.2/
     */
    public function getEndpoint(){
        if(!substr($this->endpoint_root, -1) === '/'){
            $this->endpoint_root .= '/';
        }
        return $this->endpoint_root . $this->version . '/';
    }
    
    public function sendUnirestRequest($method, $endpoint, Array $datas_or_options = null){
        $headers = array('Accept' => 'application/json');
        $query = array(
            "key" => $this->api_key,
            "token" => $this->token
        );
        if($datas_or_options){
            $query = array_merge($query, $datas_or_options);
        }

        $response = UnirestRequest::$method($endpoint, $headers, $query);
        if($response->code <= 299){
            return $response->body;
        }

        return false;
    }

}


