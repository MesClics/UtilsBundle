<?php
    namespace MC\UtilsBundle\Paginator;

    class MCPaginator{
        private $perPage;
        private $splitArray;

        public function __construct($perPage){
            $this->perPage = $perPage;
        }

        /**
         * Découpe le tableau en sous-tableaux correspondant aux pages de résultats
         * Renvoie l'objet MCPaginator
         */
        public function paginate($array){
            $this->splitArray = array_chunk($array, $this->perPage);
            return $this;
        }

        /**
         * renvoie la page de résultats passée en arguments
         */
        public function getPage($page){
            return $this->splitArray[$page - 1];
        }

        /**
         * renvoie le nb de pages de résultats
         */
        public function getPages(){
            return count($this->splitArray);
        }
    }