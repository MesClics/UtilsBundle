<?php
namespace MesClics\UtilsBundle\DataTransportObject\Mapper;

use MesClics\UtilsBundle\DataTransportObject\Mapper\ObjectToEntityMapperInterface;

class ObjectToEntityMapper implements ObjectToEntityMapperInterface{
    protected $mapping_array;
    protected $updated_datas;
    protected $getter_guesser;

    public function __construct(Array $mapping_array){
        $this->updated_datas = array();
        $this->mapping_array = $mapping_array;
    }

    public function mapDTOToEntity($dto, $entity, $save_updated_datas = true){
        $dto_properties = get_object_vars($dto);
        $entity->getId() ? $entityIsNew = false : $entityIsNew = true;
         
        if(method_exists($dto, 'beforeMappingTo')){
            $dto->beforeMappingTo($entity);
        }

        foreach($this->mapping_array as $mapping_item){
            if(array_key_exists($mapping_item->property, $dto_properties)){
                
                $property = $mapping_item->property;
                $getter = $mapping_item->getter;
                $setter = $mapping_item->setter;

                $entity_value = $entity->$getter();

                if(method_exists($dto->$property, 'getData')){
                    $dto_value = $dto->$property->getData();
                } else{
                    $dto_value = $dto->$property;
                }

                //check if the entity property value and the dto property value are the same
                if($save_updated_datas && $dto_value && ($dto_value !== $entity_value)){
                    //if entity is not new, add to updated datas
                    if(!$entityIsNew){
                        $this->addUpdatedData($property, $entity_value, $dto_value);
                    }
                }
                //update the entity
                $entity->$setter($dto_value);
            }
        }

        if(method_exists($dto, 'afterMappingTo')){
            $dto->afterMappingTo($entity);
        }
        //  TODO: guess the getters non specified in mapping_array
    }

    public function mapEntityToDTO($entity, $dto){
         $dto_properties = get_object_vars($dto);


        if(method_exists($dto, 'beforeMappingFrom')){
            $dto->beforeMappingFrom($entity);
        }
        foreach($this->mapping_array as $mapping_item){
            if(array_key_exists($mapping_item->property, $dto_properties)){
                
                $property = $mapping_item->property;
                $getter = $mapping_item->getter;
                $dto->$property = $entity->$getter();
            }
        }
        if(method_exists($dto, 'afterMappingFrom')){
            $dto->afterMappingFrom($entity);
        }

        //  TODO: guess the getters non specified in mapping_array

    }

    public function addUpdatedData($property_name, $old_value, $new_value){
        $this->updated_datas[$property_name] = array($old_value, $new_value);
    }

    public function getUpdatedDatas(){
        return $this->updated_datas;
    }

    public function getUpdatedData($property_name){
        if(in_array($property_name, $this->updated_datas)){
            return $this->updated_datas[$property_name];
        }

        return null;
    }
}