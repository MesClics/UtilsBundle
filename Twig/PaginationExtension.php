<?php
namespace MesClics\UtilsBundle\Twig;

use MesClics\UtilsBundle\Paginator\MesClicsPaginator;

class PaginationExtension extends \Twig_Extension{
    private $paginator;

    public function __construct(MesClicsPaginator $paginator){
        $this->paginator = $paginator;
    }

    public function paginate($array){
        return $this->paginator->paginate($array);
    }

    public function getPage($page){
        return $this->paginator->getPage($page);
    }

    public function getPages(){
        return $this->paginator->getPages();
    }

    public function getFunctions(){
        return array(
            new \Twig_SimpleFunction('paginate', array($this, 'paginate'))
        );
    }

    public function getFilters(){
        return array(
            new \Twig_Filter('page', array($this, 'getPage')),
            new \Twig_Filter('pages', array($this, 'getPages'))
        );
    }

    public function getName(){
        return 'MesClicsPaginator';
    }
   
}