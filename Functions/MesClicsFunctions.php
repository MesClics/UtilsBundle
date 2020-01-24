<?php

namespace MesClics\UtilsBundle\Functions;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

final class MesClicsFunctions{
    private $session;
    
    public function __construct(SessionInterface $session){
        $this->session = $session;
    }
    
    public static function addFlash(string $label, string $message, SessionInterface $session){
            $session->getFlashBag()->add($label, $message);
    }

    
    public static function string_to_multidimensional_array($string, $delimiter, $final_value = null, $invert_string = false) {
        $result = array();

        if(!$invert_string){
            $levels = explode($delimiter, $string);
        } else{
            $levels = array_reverse(explode($delimiter, $string));
        }

        if (FALSE === $levels){
            return;
        }

        $pointer = &$result;
        for ($i=0; $i<sizeof($levels); $i++) {
            if (!isset($pointer[$levels[$i]]))
            $pointer[$levels[$i]]=array();
            $pointer=&$pointer[$levels[$i]];
        }

        if(isset($final_value)){
            $pointer=$final_value;
        }

        return $result;
    }

    public static function array_merge_recursive_distinct(array &$array1, array &$array2)
    {
        $merged = $array1;
        foreach ($array2 as $key => &$value) {
            if (is_array($value) && isset($merged[$key]) && is_array($merged[$key])) {
                $merged[$key] = $this->array_merge_recursive_distinct($merged[$key], $value);
            } else {
                $merged[$key] = $value;
            }
        }
        return $merged;
    }

    public static function array_collection_diff(ArrayCollection $arrayCollectionA, ArrayCollection $arrayCollectionB){
        return $diff = $arrayCollectionA->filter(function($a) use($arrayCollectionB){
            return $arrayCollectionB->contains($a) === false;
        });
    }

    public static function my_function($arrayA, $arrayB){
        // if(empty($arrayA)){
        //     return $arrayB;
        // }

            $result = array();
        foreach($arrayB as $object){
            $result[] = $object->getId();
        }
         dump($result);
    }

    public static function in_array_recursive($needle, $haystack, $strict = false) {
        foreach ($haystack as $item) {
            if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_recursive($needle, $item, $strict))) { 
                return $item;
            }
        }

        return false;
    }
}