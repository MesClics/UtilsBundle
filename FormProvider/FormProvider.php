<?php
namespace MesClics\UtilsBundle\FormProvider;

abstract class FormProvider{
    
    private $form_generator;
    private $form_manager;

    protected function __construct($form_generator, $form_manager){
        $this->form_generator = $form_generator;
        $this->form_manager = $form_manager;
    }

    protected function getFormGenerator(){
        return $this->$form_generator;
    }
}