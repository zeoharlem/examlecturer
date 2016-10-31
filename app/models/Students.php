<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Students
 *
 * @author webadmin
 */
use Phalcon\Mvc\Model\Validator;

class Students extends \Phalcon\Mvc\Model{
    //put your code here
    public $password;
    private $_security;
    
    public function initialize(){
        $this->_security = new \Phalcon\Security();
        $this->skipAttributes(array(
            'congregation','entry'
        ));
    }
    
    public function validation(){
        $this->validate(new Validator\Uniqueness(array(
            'field'     => 'email',
            'message'   => 'Email already existed'
        )));
        if($this->validationHasFailed()){
            return false;
        }
    }
}
