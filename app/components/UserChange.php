<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author web
 */
namespace Component;

class UserChange extends \Phalcon\Mvc\User\Component{
    //put your code here
    private $_amount;
    
    public function __setArray($strVar){
        $this->_amount[] = $strVar;
    }
    
    private function __getArraySum(){
        return array_sum($this->_amount);
    }
}
