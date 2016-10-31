<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Lecturer
 *
 * @author web
 */
use Phalcon\Mvc\Model\Validator;

class Lecturer extends BaseModel{
    public $password, $codename;
    
    public function initialize(){
        $this->belongsTo(
            'codename',
            'Lecturer',
            'codename',
            array(
                'reusable'  => true,
                //'alias'     => 'SimilarLecturer'
            ));
        $this->belongsTo(
            'codename',
            'Departments','codename',
            array(
                'reusable'  => true,
                //'alias'     => 'SimilarDepartments'
            ));
    }
    
    public function beforeValidationOnCreate(){
        $component = $this->getDI()->getComponent();
        $this->password = $component->helper->makeRandomString(4);
        $this->codename = $component->helper->makeRandomInts();
    }
    
    public function afterValidationOnCreate(){
        
    }
    
    public function validation(){
        $this->validate(new Validator\Uniqueness(array(
            'field'     => 'email',
            'message'   => 'Your email is already in use'
        )));
        
        $this->validate(new Validator\Email(array(
            'field'     => 'email',
            'message'   => 'Email is not valid in use'
        )));
        
        $this->validate(new Validator\Uniqueness(array(
            'field'     => 'codename',
            'message'   => 'Codename is already in use'
        )));
        
        if($this->validationHasFailed()){
            return false;
        }
    }
}
