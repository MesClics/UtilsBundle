<?php
namespace MesClics\UtilsBundle\DataTransportObject\Mapper;

interface ObjectToEntityMapperInterface{
    public function mapDTOToEntity($dto, $entity);
    public function mapEntityToDTO($entity, $dto);
}