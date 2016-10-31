<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Course
 *
 * @author web
 */
use Phalcon\Mvc\Model\Validator;

class Course extends BaseModel{
    public function initialize(){
        
    }
    
    public function beforeValidationOnCreate(){
        $this->skipAttributesOnCreate(array(
            'lecturer', 'lectcode'
        ));
    }
    
    public function validation(){
        $this->validate(new Validator\Uniqueness(array(
            'field'     => 'code',
            'message'   => 'Course code already existed'
        )));
        
        if($this->validationHasFailed()){
            return false;
        }
    }
}
