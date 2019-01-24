<?php
    namespace MesClics\UtilsBundle\Paginator;

    class MesClicsPaginator{
        private $splitArray;

        /**
         * Découpe le tableau en sous-tableaux correspondant aux pages de résultats (selon le nb de résultats souhaité par page $perPage)
         * Renvoie l'objet MesClicsPaginator
         */
        public function paginate(array $array, int $perPage){
            $this->splitArray = array_chunk($array, $perPage);
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