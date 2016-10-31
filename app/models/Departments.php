<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Departments
 *
 * @author web
 */
use \Phalcon\Mvc\Model\Validator;

class Departments extends \Phalcon\Mvc\Model{
    
    public function initialize(){
        $this->belongsTo(
            'codename',
            'Lecturer',
            'codename',
            array(
                'reusable'  => true,
                'alias'     => 'SimilarLecturer'
            ));
        $this->belongsTo(
                'codename',
                'Departments','codename',
                array(
                    'reusable'  => true,
                    'alias'     => 'SimilarDepartments'
                ));
    }
    
    public function validation(){
        $this->validate(new Validator\Uniqueness(array(
            'field'     => 'description',
            'message'   => 'Your description is already in use'
        )));
        
        if($this->validationHasFailed()){
            return false;
        }
    }
}
