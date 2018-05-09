<?php
namespace MC\UtilsBundle\Twig;

use MC\UtilsBundle\HTMLAttrAdder\HTMLAttrAdder;

class HTMLAttrAdderExtension extends \Twig_Extension{
    private $HTMLAttrAdder;
    
    public function __construct(HTMLAttrAdder $HTMLAttrAdder){
        $this->HTMLAttrAdder = $HTMLAttrAdder;
    }

    public function attr_add($attr_type, $if, $if_attr, $elseif = false, $elseif_attr = false, $else_attr = false){
        echo $this->HTMLAttrAdder->addAttrIf($attr_type, $if, $if_attr, $elseif = false, $elseif_attr = false, $else_attr = false);
    }

    public function getFunctions(){
        return array(
            new \Twig_SimpleFunction('HTMLAttrAdd', array($this, 'attr_add'))
        );
    }

    public function getName(){
        return 'MesClicsHTMLAttrAdder';
    }
}