<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ResultCarry
 *
 * @author WEB
 */
class ResultCarry extends BaseModel{
    public function initialize(){
        $this->setSource('resultcarry');
        $this->belongsTo(
                'creg_id',
                'Carryover',
                'creg_id',
                array(
                    'reusable'  => true
                )
        );
        $this->belongsTo(
                'creg_id',
                'ResultCarry',
                'creg_id',
                array(
                    'reusable'  => true
                )
        );
    }
}
