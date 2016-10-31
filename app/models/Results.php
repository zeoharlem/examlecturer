<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Results
 *
 * @author web
 */
class Results extends BaseModel{
    public function initialize(){
        $this->setSource('result');
        $this->belongsTo(
                'creg_id',
                'Courseregistration',
                'creg_id',
                array(
                    'reusable'  => true,
                    //'alias'     => 'SimilarResult'
                )
            );
        $this->belongsTo(
                'creg_id', 
                'Results', 
                'creg_id', array(
                    'reusable'  => true,
                    //'alias'     => 'similarRegCourse'
                ));
    }
    
    public function beforeOnCreate(){
        $criteria = new \Phalcon\Mvc\Model\Criteria();
        $criteria->columns(array('course','exam','ca','matric','creg_id'));
    }
    
    public function beforeOnUpdate(){
        $criteria = new \Phalcon\Mvc\Model\Criteria();
        $criteria->columns(array('course','exam','ca','matric','creg_id'));
    }
}
