<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class GlobalVar
{

    private $name;

    
    public function setName($name){
        $this->name = $name;
    }
    public function getName(){
        return $this->name;
    }

}