<?php
namespace MesClics\UtilsBundle\Twig;

use MesClics\UtilsBundle\Paginator\MesClicsPaginator;

class PaginationExtension extends \Twig_Extension{
    private $paginator;

    public function __construct(MesClicsPaginator $paginator){
        $this->paginator = $paginator;
    }

    public function paginate(array $array, int $perPage){
        return $this->paginator->paginate($array, $perPage);
    }

    public function getFunctions(){
        return array(
            new \Twig_SimpleFunction('paginate', array($this, 'paginate'))
        );
    }

    public function getFilters(){
        return array(
            new \Twig_Filter('page', array($this->paginator, 'getPage')),
            new \Twig_Filter('pages', array($this->paginator, 'getPages'))
        );
    }

    public function getName(){
        return 'MesClicsPaginator';
    }
   
}