<?php

namespace MesClics\UtilsBundle\Functions;

use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

final class MesClicsFunctions{
    private $session;
    
    public function __construct(SessionInterface $session){
        $this->session = $session;
    }

    public function string_to_camel(string $foo){
        // replace underscores and - by blanks
        $foo = str_replace("_", " ", $foo);
        $foo = str_replace("-", " ", $foo);
        // lowercase everything
        $foo = strtolower($foo);
        // uppercase first letter of each word
        $foo = ucwords($foo);
        // remove blanks
        $foo = str_replace(" ", "", $foo);
        // lowercase first letter
        $foo = lcfirst($foo);
        return $foo;
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
                $merged[$key] = self::array_merge_recursive_distinct($merged[$key], $value);
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

     public static function getQueryOrderParams(Request $request, string $default_order_by = null, int $limit = null){
        $res = array(
            'by' => $default_order_by,
            'direction' => null,
            'offset' => 0,
            'limit' => $limit
        );

        if($request->query->get('page')){
            // get orderBy param
            $res['page'] = $request->query->get('page');
            if($limit){
                $res['offset'] += (intval($res['page']) - 1) * $limit;
            }
        } else if($limit){
            $res['page'] = 1;
        };

        if($request->query->get('order-by')){
            $res['by'] = MesClicsFunctions::string_to_camel($request->query->get('order-by'));
        }

        if($request->query->get('order')){
            $res['direction'] = $request->query->get('order');
        }

        if(empty($res)){
            return null;
        }
        return $res;
    }
}