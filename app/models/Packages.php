<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Packages
 *
 * @author web
 */
class Packages extends BaseModel{
    
    public function initialize(){
        $this->setSource('package_modules');
    }
}
