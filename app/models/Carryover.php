<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CarryOver
 *
 * @author web
 */
class Carryover extends BaseModel{
    public function initialize(){
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
