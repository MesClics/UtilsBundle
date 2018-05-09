<?php
namespace MesClics\UtilsBundle\HTMLAttrAdder;
use Symfony\Component\OptionsResolver\Exception\InvalidArgumentException;

class HTMLAttrAdder{

    private $attr_types;

    public function __construct(){
        $this->attr_types = array(
            'path',
            'string'
        );
    }

    public function addAttrIf($attr_type, $if, $if_attr, $elseif = false, $elseif_attr = false, $else_attr = false){
        //on vérifie que l'attr_type soit valide
        if(!in_array($attr_type, $this->attr_types)){
            throw new InvalidArgumentException('Le type d\'attribut (@attr_type) ne peut être que l\'un des suivants : ' . implode(', ', $this->attr_types));
        }
        
        //on définit le nom de la méthode à appeler en fonction du attr_type

        $method_name = 'return' . ucfirst($attr_type);
        return $this->$method_name($if, $if_attr, $elseif, $elseif_attr, $else_attr);
    }

    public function returnPath($if, $if_attr, $elseif, $elseif_attr, $else_attr){
        // $twigIfElse = '{% if ' . $if . ' %}{{ path(' . $if_attr . ') }}';
        
        // if($elseif){
        //     $twigIfElse .= '{% elseif ' . $elseif . ' %}{{ path(' . $elseif_attr . ') }}';
        // }

        // if($else_attr){
        //     $twigIfElse .= '{% else %}{{ path(' . $else_attr . ') }}';
        // }

        // $twigIfElse .= '{% endif %}';

        // return $twigIfElse;
        if($if){
            return $this->router.generate($if_attr);
        } elseif($elseif){
            return $this->router.generate($elseif_attr);
        } else{
            return $this->router.generate($else);
        }
    }

    public function returnString($if, $if_attr, $elseif, $elseif_attr, $else_attr){
        $twigIfElse = '{% if ' . $if . ' %}$if_attr
        ';
        
        if($elseif){
            $twigIfElse .= '{% elseif ' . $elseif . ' %}' . $elseif_attr;
        }

        if($else_attr){
            $twigIfElse .= '{% else %}' . $else_attr;
        }

        $twigIfElse .= '{% endif %}';

        return $twigIfElse;
    }
}