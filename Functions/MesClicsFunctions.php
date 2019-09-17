<?php

namespace MesClics\UtilsBundle\Functions;

class MesClicsFunctions{
    
    public function string_to_multidimensional_array($string, $delimiter, $final_value = null, $invert_string = false) {
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

    public function array_merge_recursive_distinct(array &$array1, array &$array2)
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
}