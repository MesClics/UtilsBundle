<?php

namespace MesClics\UtilsBundle\RestApiHandler;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;
use MesClics\UtilsBundle\RestApi\RestApi;
use MesClics\UtilsBundle\RestApi\RestApiRequest;

abstract class RestApiConsumer{
    private $api;
    private $api_key;
    private $dev_token;
    private $requests;

    public function __construct(RestApi $api, $options){
        if($options['api_key']){ $this->api_key = $options['api_key']; }
        if($options['dev_token']){ $this->dev_token = $options['dev_token']; }
        $this->requests = new ArrayCollection;
    }

    public function addRequest(RestApiRequest $request){
        $this->requests->add($request);
    }

    public function getRequest($request_name){
        return $this->requests[$request_name];
    }

    public function removeRequest(RestApiRequest $request){
        $this->requests->remove($request);
    }

    public function executeRequest(RestApiRequest $request){
        $request_uri = $this->getUri();
    }

    /**
     * Get Endpoint
     * @return $endpoint (default: endpoint_root/version/endpoint_path/) 
     */
    public function getEndpoint(RestApiRequest $request){
        $endpoint = $this->api->getEndpoint();
        if(!substr($endpoint, -1) === '/'){
            $endpoint .= '/';
        }

        $version = $this->api->getVersion();
        if(!substr($version, -1) === '/'){
            $version .= '/';
        }

        $endpoint_path = $request->getEndpointPath();
        if(!substr($endpoint_path, -1) === '/'){
            $endpoint_path .= '/';
        }

        return $endpoint_root . $version . $endpoint_path;
    }
}