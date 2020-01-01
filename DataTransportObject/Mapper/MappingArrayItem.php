<?php
namespace MesClics\UtilsBundle\DataTransportObject\Mapper;

class MappingArrayItem{
    public $updated_data_name;
    public $dto_getter;
    public $dto_setter;
    public $entity_getter;
    public $entity_setter;

    /**
     * the constructor must at leat receive a name that could be used to store the updated data, an array of the dto's parameter getter and setter (in this order). If the entity getter and setter are different from the dto's ones, the constructor must receive a second array for these entity's getter and setter
     */
    public function __construct(string $updated_data_name, array $dtoGetterAndSetter, array $entityGetterAndSetter = null){
        $this->updated_data_name = $updated_data_name;
        $this->dto_getter = $dtoGetterAndSetter[0];
        $this->dto_setter = $dtoGetterAndSetter[1];

        if($entityGetterAndSetter){
            $this->entity_getter = $entityGetterAndSetter[0];
            $this->entity_setter = $entityGetterAndSetter[1];
        } else{
            $this->entity_getter = $dtoGetterAndSetter[0];
            $this->entity_setter = $dtoGetterAndSetter[1];
        }
    }
}