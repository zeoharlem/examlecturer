<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of IndexController
 *
 * @author web
 */
class IndexController extends BaseController{
    private $_registerUser, $_admin;
    
    public function initialize(){
        parent::initialize();
    }
    
    public function indexAction(){
        if($this->request->isPost()){
            $users = Lecturer::findFirst(array(
                "email = :username: AND password = :password:",
                'bind'  => array(
                    'username'  => $this->request->getPost('username'),
                    'password'  => $this->request->getPost('password')
                ))
            );
            if($users){
                $this->__registerAdmin($users);
                $this->__checkHodLecturer($users);
                $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_NO_RENDER);
                $this->flash->success('<strong>Welcome '.ucwords($users->firstname).'</strong>');
                $this->response->redirect('dashboard/');
            }
            else{
                //$this->component->helper->getErrorMsgs($users, 'index');
                $this->flash->success('<strong>Not a valid user</strong>');
                $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
            }
        }
        $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_LAYOUT);
    }
    
    public function logOutAction(){
        $this->session->destroy();
        $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_NO_RENDER);
        $this->response->redirect('index/?logout=true');
    }
    
    public function __removeKey($key){
        $this->session->remove($key);
    }
    
    private function __checkUserLogin($post){
        $register = Students::findFirstByMatric($post->getPost('username'));
        if($register){
            if($this->security->checkHash($post->getPost('password'), 
                    $register->password)){
                $this->__registerAdmin($register);
                return true;
            }
            else{
                return false;
            }
        }
        return $register;
    }
    
    /**
     * @param Lecturer $lecturer
     */
    private function __checkHodLecturer(Lecturer $lecturer){
        $similarHod = $lecturer->departments;
        if(!is_null($similarHod->codename)){
            $this->session->set('hod', array(
                'hodaccess' => $similarHod->codename,
                'hodname'   => $similarHod->headofdepartment,
                'hoddept'   => $similarHod->description
            ));
        }
    }
    
    /**
     * @param Lecturer $admin
     * Register the lecturer's details into session 
     */
    private function __registerAdmin(Lecturer $admin){
        $this->session->set('auth', array('lecturer_id'=>$admin->lecturer_id,
            'codename'=>$admin->codename,'firstname'=>$admin->firstname,
            'email'=>$admin->email,'role'=>$admin->role,'lastname'=>$admin->lastname));
    }
}
