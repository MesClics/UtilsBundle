<?php
namespace MC\UtilsBundle\FormGenerator;

abstract class FormGenerator{
    private $object;

    abstract function __construct($object);

    protected function getForm($form_name){
        $form_name = strtoupper($form_name);
        $form_path = static::$form_name . '.php'; 
        if(!file_exists($form_path)){
            throw new HttpException('409', 'Le formulaire ' . $form_name . ' n\'existe pas au chemin ' . $form_path);
        }
        
        $camelCase = str_replace('_', '', ucwords(strtolower($form_name, "_")));
        $callable = 'get' . $camelCase . '()';

        $this->$callable;
    }
}

//Client form Generator :
    
    // private $client;
    // const NEW_CLIENT = "MC\EspaceClient\Form\ClientType";
    // const EDIT_CLIENT = "MC\EspaceClient\Form\ClientType";

    // public function setClient(Client $client){
    //     $this->client = $client;
    // }

    // public function getNewClient(){
    //     var_dump('fournit le formulaire new client');
    //     die();
    // }

    // public function getEditClient(){
    //     var_dump('fournit le formulaire edit client');
    //     die();
    // }