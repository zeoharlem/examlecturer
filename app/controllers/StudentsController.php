<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of StudentsController
 *
 * @author webadmin
 */
class StudentsController extends BaseController{
    private $_students, $_builder;
    
    public function initialize() {
        parent::initialize();
        Phalcon\Tag::appendTitle("Students");
        $this->_students = Students::find();
        $this->_builder = new \Phalcon\Mvc\Model\Query();
        $this->__dataTableJsCss();
    }
    public function indexAction(){
        $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
    }
    
    public function registerAction(){
        if($this->request->isPost()){
            $students = new Students();
            $results = $students->create($this->request->getPost());
            if($results != false){
                $this->flash->success('<strong>Registration Completed</strong>');
                $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
                return true;
            }
            else{
                $this->component->helper->getErrorMsgs($students,'students/register');
            }
        }
    }
    
    public function checkMatricAction(){
        if($this->request->isAjax() && $this->request->isPost()){
            
        }
    }
    
    public function getStudentsAction(){
        $builder = array();
        $getPackages = $this->modelsManager
                ->createBuilder()->from('Courseregistration')
                ->where('lecturer="'.$this->session->get('auth')['codename'].'"')
                ->getQuery()->execute();
        
        foreach($getPackages as $keys => $values){
            $students = Students::findFirstByMatric($values->matric);
            $builder[] = array(
                'creg_id'   => $values->creg_id,
                'firstname' => @$students->surname.' '.@$students->othernames,
                'title'     => $values->title,
                'course'    => $values->code,
                'session'   => $values->session,
                'matric'    => @$students->matric,
                'level'     => $values->level,
                'department'=> $values->department
            );
        }
        $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_NO_RENDER);
        $this->__dataTableFlow($builder, 'toArray');
    }
    
    protected function __dataTableFlow($builder, $type='builder', $column=array()){
        if($this->request->isAjax()){
            $dataTables = new \DataTables\DataTable();
            switch($type){
                case 'builder':
                    return $dataTables->fromBuilder(
                            $builder, $column)->sendResponse();
                    break;
                case 'toArray':
                    return $dataTables->fromArray(
                            $builder, $column)->sendResponse();
                    break;
                case 'resultset':
                    return $dataTables->fromResultSet(
                            $builder, $column)->sendResponse();
                    break;
                default :
                    return $dataTables->fromBuilder(
                            $builder, $column)->sendResponse();
                    break;
            }
        }
        //$this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_NO_RENDER);
    }
}
