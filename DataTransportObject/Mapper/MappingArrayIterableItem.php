<?php
namespace MesClics\UtilsBundle\DataTransportObject\Mapper;

class MappingArrayIterableItem{
    public $updated_data_name;
    public $dto_getter;
    public $dto_adder;
    public $dto_remover;
    public $entity_getter;
    public $entity_adder;
    public $entity_remover;

    /**
     * the constructor must at leat receive a name that could be used to store the updated data, an array of the dto's parameter getter and adder and remover (in this order). If the entity getter and setter are different from the dto's ones, the constructor must receive a second array for these entity's getter and adder and remover
     * remover can be null (if you want a dto field only to be an adder to the collection of objects(ex: for select field))
     */
    public function __construct(string $updated_data_name, array $dtoGetterAdderRemover, array $entityGetterAdderRemover = null){
        $this->updated_data_name = $updated_data_name;
        $this->dto_getter = $dtoGetterAdderRemover[0];
        $this->dto_adder = $dtoGetterAdderRemover[1];
        $this->dto_remover = $dtoGetterAdderRemover[2];

        if($entityGetterAdderRemover){
            $this->entity_getter = $entityGetterAdderRemover[0];
            $this->entiity_adder = $entityGetterAdderRemover[1];
            $this->entity_remover = $entityGetterAdderRemover[2];
        } else{
            $this->entity_getter = $dtoGetterAdderRemover[0];
            $this->entity_adder = $dtoGetterAdderRemover[1];
            $this->entity_remover = $dtoGetterAdderRemover[2];
        }
    }
}