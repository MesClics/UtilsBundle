<?php

    namespace MesClics\UtilsBundle\Pluralizer;

    class MesClicsPluralizer{
        private $plural;
        private $var_more_than_one;

        protected function isPlural(){
            if(is_array($this->var_more_than_one) && count($this->var_more_than_one) > 1){
                return true;
            }

            if(is_int($this->var_more_than_one) && $this->var_more_than_one > 1){
                return true;
            }

            return false;
        }

        public function pluralize(string $singular, string $plural, $var_more_than_one){
            $this->plural = $plural;
            $this->var_more_than_one = $var_more_than_one;

            if(!$this->isPlural()){
                return $singular;
            }

            return $this->plural;
        }
    }