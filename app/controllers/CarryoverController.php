<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CarryoverController
 *
 * @author web
 */
use Phalcon\Mvc\View;

class CarryoverController extends BaseController{
    public function initialize() {
        parent::initialize();
        $codename = $this->session->get('auth')['codename'];
        $this->view->courses = Packages::find('lecturer="'.$codename.'"');
    }
    
    public function indexAction(){
        $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_LAYOUT);
    }
    
    public function getCarryOverAction(){
        if($this->request->isPost()){
            $carryOver = Carryover::find(array(
                "conditions"    => $this->__conditionsRemoveEmpty(),
                "bind"          => $this->__bindAfterRemoveEmpty()
            ));
            if($carryOver != false){
                $this->view->setVars(array('carryover' => $carryOver));
            }
            $this->view->setRenderLevel(View::LEVEL_AFTER_TEMPLATE);
        }
    }
    
    public function postOverAction(){
        if($this->request->isPost()){
            $carryOver = new Carryover();
            $arrays = $this->request->getPost();
            $results = $carryOver->__replaceMultiRaw($arrays, 'resultcarry');
            if($results != false){
                $this->flash->success('<strong>Carry Over Results Uploaded</strong>');
                $this->view->setRenderLevel(View::LEVEL_LAYOUT);
            }
            else{
                $this->component->helper->getErrorMsgs($carryOver,'carryover');
            }
        }
    }
}
