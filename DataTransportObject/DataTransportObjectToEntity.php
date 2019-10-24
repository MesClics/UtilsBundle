<?php

namespace MesClics\UtilsBundle\DataTransportObject;

use MesClics\UtilsBundle\DataTransportObject\Mapper\ObjectToEntityMapper;
use MesClics\UtilsBundle\DataTransportObject\DataTransportObjectToEntityInterface;

abstract class DataTransportObjectToEntity implements DataTransportObjectToEntityInterface{
    protected $mapper;

    public function __construct(){
        $mapping_array = $this->getMappingArray();
        $this->mapper = new ObjectToEntityMapper($mapping_array);
    }

    /**
     * returns an array of MappingItem objects that define 
     * the mapping between each DataTransportObject property 
     * to an Entity's property
     */
    abstract public function getMappingArray();

    /**
     * shortend to $this->mapper::mapDTOToEntity();
     */
    public function mapTo($entity, $save_updated_datas = true){
        $this->mapper->mapDTOToEntity($this, $entity, $save_updated_datas);
    }

    /**
     * shortend to $this->mapper::mapEntityToDTO()
     */
    public function mapFrom($entity){
        $this->mapper->mapEntityToDTO($entity, $this);
    }

    /**
     * shortend to $this->mapper->getUpdatedDatas();
     */
    public function getUpdatedDatas(){
        return $this->mapper->getUpdatedDatas();
    }

    
    /**
     * shortend to $this->mapper->getUpdatedData();
     */
    public function getUpdatedData($property_name){

        return $this->mapper->getUpdatedData($property_name);
    }

    /**
     * shortend to $this->mapper->addUpdatedData();
     */
    public function addUpdatedData($property_name, $old_value, $new_value){
        $this->mapper->addUpdatedData($property_name, $old_value, $new_value);
    }
}