<?php
namespace MesClics\UtilsBundle\DataTransportObject\Mapper;

use MesClics\UtilsBundle\Functions\MesClicsFunctions;
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
         
        if(method_exists($dto, 'beforeMappingTo')){
            $dto->beforeMappingTo($entity);
        }

        foreach($this->mapping_array as $mapping_item){
            
            if(get_class($mapping_item) === MappingArrayItem::class){            
                $this->mapDTOPropertyToEntity($mapping_item, $dto, $entity, $save_updated_datas);
            }

            if(get_class($mapping_item) === MappingArrayIterableItem::class){
                $this->mapDTOIterablePropertyToEntity($mapping_item, $dto, $entity, $save_updated_datas);
            }
        }

        if(method_exists($dto, 'afterMappingTo')){
            $dto->afterMappingTo($entity);
        }
        //  TODO: guess the getters non specified in mapping_array
    }

    protected function mapDTOPropertyToEntity($mapping_item, $dto, $entity, $save_updated_datas = true){
            $updated_data_name = $mapping_item->updated_data_name;
            $dto_getter = $mapping_item->dto_getter;
            $entity_getter = $mapping_item->entity_getter;
            $entity_setter = $mapping_item->entity_setter;

            $entity_value = $entity->$entity_getter();

            if(method_exists($dto_getter, 'getData')){
                $dto_value = $dto->$dto_getter()->getData();
            } else{
                $dto_value = $dto->$dto_getter();
            }

            //check if the entity property value and the dto property value are the same
            if($save_updated_datas && ($dto_value !== $entity_value)){
                //if entity is not new, add to updated datas
                if($entity->getId()){
                    $this->addUpdatedData($updated_data_name, $entity_value, $dto_value);
                }
            }
            //update the entity
            if($dto_value){
                $entity->$entity_setter($dto_value);
            }
    }

    protected function mapDTOIterablePropertyToEntity($mapping_item, $dto, $entity, $save_updated_datas = true){
        $updated_data_name = $mapping_item->updated_data_name;
        $dto_getter = $mapping_item->dto_getter;
        $entity_getter = $mapping_item->entity_getter;
        $entity_adder = $mapping_item->entity_adder;
        $entity_remover = $mapping_item->entity_remover;

        // add dto elements not yet present into entity collection
        foreach($dto->$dto_getter() as $elt){
           if(!$entity->$entity_getter()->contains($elt)){
               $entity->$entity_adder($elt);
           }
        }


        //remove from entity collection elements not present in dto if $entity remover is set
        if($entity_remover){
            foreach($entity->$entity_getter() as $elt){
                if(!in_array($elt, $dto->$dto_getter())){
                    $entity->$entity_remover($elt);
                }
            }
        }
    }

    public function mapEntityToDTO($entity, $dto){
         $dto_properties = get_object_vars($dto);

        if(method_exists($dto, 'beforeMappingFrom')){
            $dto->beforeMappingFrom($entity);
        }

        foreach($this->mapping_array as $mapping_item){
            if(get_class($mapping_item) === MappingArrayItem::class){
                $this->mapEntityPropertyToDTO($mapping_item, $entity, $dto);
            }

            if(get_class($mapping_item) === MappingArrayIterableItem::class){
                $this->mapEntityIterablePropertyToDTO($mapping_item, $entity, $dto);
            }
        }

        if(method_exists($dto, 'afterMappingFrom')){
            $dto->afterMappingFrom($entity);
        }

        //  TODO: guess the getters non specified in mapping_array

    }

    protected function mapEntityPropertyToDTO($mapping_item, $entity, $dto){
        $dto_setter = $mapping_item->dto_setter;
        $entity_getter = $mapping_item->entity_getter;
        if($entity->$entity_getter()){
            $dto->$dto_setter($entity->$entity_getter());
        }
    }

    protected function mapEntityIterablePropertyToDTO($mapping_item, $entity, $dto){
        $updated_data_name = $mapping_item->updated_data_name;
        $entity_getter = $mapping_item->entity_getter;
        $dto_adder = $mapping_item->dto_adder;

        foreach($entity->$entity_getter() as $element){
            $dto->$dto_adder($element);
        }
    }



    public function addUpdatedData($updated_data_name, $old_value, $new_value){
        $this->updated_datas[$updated_data_name] = array($old_value, $new_value);
    }

    public function getUpdatedDatas(){
        return $this->updated_datas;
    }

    public function getUpdatedData($updated_data_name){
        if(array_key_exists($updated_data_name, $this->updated_datas)){
            return $this->updated_datas[$updated_data_name];
        }

        return null;
    }
}