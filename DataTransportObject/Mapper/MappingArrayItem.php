<?php
namespace MesClics\UtilsBundle\DataTransportObject\Mapper;

class MappingArrayItem{
    public $property;
    public $getter;
    public $setter;

    public function __construct($property, $getter, $setter){
        $this->property = $property;
        $this->getter = $getter;
        $this->setter = $setter;
    }
}