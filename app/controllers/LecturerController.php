<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LecturerController
 *
 * @author web
 */
class LecturerController extends BaseController{
    public function indexAction(){
        $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
    }
    
    //Method must send mail to lecturer
    //But will be addressed later
    public function createAction(){
        if($this->request->isPost()){
            $lecturer = new Lecturer();
            if($lecturer->create($this->request->getPost())){
                $this->flash->success('<strong>Lecturer Created</strong>');
                $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_NO_RENDER);
                $this->response->redirect('lecturer/');
            }
            else{
                $this->component->helper->getErrorMsgs($lecturer,'lecturer/');
            }
        }
    }
    
    public function setAssignAction(){
        $response = new Phalcon\Http\Response();
        if($this->request->isPost() && $this->request->isAjax()){
            $code = $this->request->getPost('code');
            $course = Course::findFirstByCode($code);
            if($course != false){
                
                $lect_id = $this->request->getPost('codename');
                $name = Lecturer::findFirstByCodename($lect_id);
                //$arr = array('lecturer' => $lect_id);
                $course->lectcode = $lect_id;
                $course->lecturer = $name->firstname.' '.$name->lastname;
                if($course->update() != false){
                    
                    $response->setJsonContent(array(
                        'status'    => 'OK',
                        'data'      => array(
                            'firstname' => ucwords($name->firstname),
                            'lastname'  => ucwords($name->lastname),
                            'email'     => $name->email
                        )
                    ));
                }
                else{
                    $response->setJsonContent(array(
                        'status'    => 'ERROR',
                        'message'   => $course->getMessages()
                    ));
                }
            }
            else{
                $response->setJsonContent(array(
                    'status'    => 'ERROR',
                    'message'   => $course->getMessages()
                ));
            }
        }
        $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_NO_RENDER);
        $response->setHeader("Content-Type", "application/json");
        $response->setRawHeader("HTTP/1.1 200 OK");
        $response->send();
    }
    
    public function getLecturerAction(){
        $response = new Phalcon\Http\Response();
        $lecturer = Lecturer::find()->toArray();
        foreach($lecturer as $keys => $values){
            $lecturerArray[] = array(
                'lecturer_id'   => $values['lecturer_id'],
                'fullname'=> $values['firstname'].' '.$values['lastname'],
                'codename'      => $values['codename'],
                'email'         => $values['email']
            );
        }
        
        $response->setJsonContent(array(
            'status'    => 'OK',
            'data'      => $lecturerArray,
            //'message'   => $lecturer->getMessages()
        ));
        $response->setHeader("Content-Type", "application/json");
        $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_NO_RENDER);
        $response->send();
    }
    
    public function tableFlowAction(){
        //$this->__setJsonFlows();
        $builder = $this->modelsManager
                ->createBuilder()->columns(array(
                    'title','code','session','department','c_id'
                ))->from('Course');
        $this->__dataTableFlow($builder);
        $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_NO_RENDER);
    }
    
    public function assignAction(){
        $this->__callBackJsCss();
        $this->view->allCourses = Course::find();
        $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
    }
    
    public function __callBackJsCss(){
        $this->assets->collection('headers')
                ->addCss('assets/js/data-tables/DT_bootstrap.css')
                ->addCss('assets/js/advanced-datatable/css/demo_table.css')
                ->addCss('assets/js/advanced-datatable/css/demo_table.css');
        $this->assets->collection('footers')
                ->addJs('assets/js/advanced-datatable/js/jquery.dataTables.js')
                ->addJs('assets/js/data-tables/DT_bootstrap.js')
                ->addJs('assets/js/bootbox.js')
                ->addJs('assets/js/dynamic_table_init.js');
    }
    
    protected function __dataTableFlow($builder){
        if($this->request->isAjax()){
            $dataTables = new \DataTables\DataTable();
            return $dataTables->fromBuilder($builder)->sendResponse();
        }
        //$this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_NO_RENDER);
    }
}
