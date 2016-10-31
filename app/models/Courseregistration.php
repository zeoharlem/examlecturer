<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CourseRegistration
 *
 * @author web
 */
class Courseregistration extends BaseModel{
    
    public function initialize(){
        $this->setSource('courseregistration');
        $this->belongsTo(
                'creg_id', 
                'Results', 
                'creg_id', array(
                    'reusable'  => true,
                    //'alias'     => 'similarRegCourse'
                ));
        $this->belongsTo(
                'creg_id',
                'Courseregistration',
                'creg_id',
                array(
                    'reusable'  => true,
                    //'alias'     => 'SimilarResult'
                )
            );
    }
}
