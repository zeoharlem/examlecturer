<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PackagesController
 *
 * @author web
 */
class PackagesController extends BaseController{
    public function initialize() {
        parent::initialize();
        $this->assets->collection('footers')
                ->addJs('assets/js/bootbox.js');
    }
    
    public function indexAction(){
        $this->view->setVars(array(
            'courses' => Course::find(),'depts' => Departments::find()
            )
        );
        if($this->request->isPost()){
            $courses = $this->modelsManager->createBuilder()
                    ->from('Course')->where('department="'.$this->request->getPost('department').'"')
                    ->andWhere('level="'.$this->request->getPost('level').'"');
            $this->view->courseList = $courses->getQuery()->execute();
            $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
        }
        $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_LAYOUT);
    }
    
    public function packageFormAction(){
        $varDetails = $this->request->getPost();
        if($this->request->isPost() && $this->request->isAjax()){
            $response = new Phalcon\Http\Response();
            foreach($this->request->getPost('checkboxId') as $values){
                $results = Course::findFirstByC_id($values);
                $getPostVal['c_id'][]       = $results->c_id;
                $getPostVal['level'][]      = $results->level;
                $getPostVal['title'][]      = $results->title;
                $getPostVal['units'][]      = $results->units;
                $getPostVal['department'][] = $results->department;
                $getPostVal['lecturer'][]   = $results->lectcode;
                $getPostVal['codename'][]   = $results->codename;
                $getPostVal['status'][]     = $results->status;
                $getPostVal['code'][]       = $results->code;
            }
            
            $packages = new Packages();
            $others = ', session="'.$this->request->getPost('session').'"';
            $others .= ', semester="'.  $this->request->getPost('semester').'"';
            $results = $packages->__postRawSQLTask($getPostVal, 'package_modules', $others);
            if($results == true){
                $response->setJsonContent(array(
                    'status'    => 'OK',
                    'data'      => array(
                        'session'   => $this->request->getPost('session'),
                        'semester'  => $this->request->getPost('semester'),
                        'department'=> $getPostVal['department'][0],
                        'level'     => $getPostVal['level'][0]
                    )
                ));
                $response->setRawHeader("HTTP/1.1 200 OK");
            }
            else{
                $response->setJsonContent(array(
                    'status'    => 'ERROR',
                    'data'      => $packages->getMessages()
                ));
            }
        }
        $response->setHeader("Content-Type", "application/json");
        $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_NO_RENDER);
        $response->send();
    }
    
    public function editPackagesAction(){
        $builder = $this->modelsManager->createBuilder()->columns(array(
                    'title','code','session','department','package_id','semester','lecturer'
                ))->from('Packages')->orderBy('package_id');
        $this->__dataTableFlow($builder);
        $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_NO_RENDER);
    }
    
    public function editAction($package_id=''){
        if($this->request->isPost() && $this->request->isAjax()){
            $response = new Phalcon\Http\Response();
            $pack = Packages::findFirstByPackage_id($this->request->getPost('package_id'));
            if($pack != false){
                $response->setHeader("Content-Type", "application/json");
                $response->setJsonContent(array(
                    'status'    => 'OK',
                    'data'      => array(
                        'title'         => ucwords($pack->title),
                        'code'          => $pack->code,
                        'department'    => $pack->department,
                        'level'         => $pack->level,
                        'units'         => $pack->session,
                        'semester'      => $pack->semester,
                        'package_id'    => $pack->package_id
                    )
                ));
            }
            else{
                $response->setHeader("Content-Type", "application/json");
                $response->setJsonContent(array(
                    'status'    => 'ERROR',
                    'message'   => $pack->getMessage()
                ));
            }
            $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_NO_RENDER);
            $response->setRawHeader('HTTP/1.1 200 OK');
            $response->send();
        }
        else{
            $pack = Packages::findFirstByPackage_id(
                    $this->request->getQuery($package_id));
            if($pack != false){
                $this->view->setVar('showPackage', $pack);
                $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
            }
        }
    }
    
    public function editPostAction(){
        $response = new Phalcon\Http\Response();
        if($this->request->isPost() && $this->request->isAjax()){
            $editPackage = new Packages();
            if($editPackage->update($this->request->getPost())){
                $response->setJsonContent(array(
                    'status'    => 'OK',
                    'data'      => $editPackage->getMessages()
                ));
            }
            else{
                $response->setJsonContent(array(
                    'status'    => 'ERROR',
                    'data'      => $editPackage->getMessages()
                ));
            }
            $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_NO_RENDER);
            $response->setHeader('Content-Type', 'application/json');
            $response->send();
        }
    }
    
    public function deleteAction(){
        $response = new Phalcon\Http\Response();
        if($this->request->isAjax() && $this->request->isPost()){
            $packages = Packages::findFirstByPackage_id(
                    $this->request->getPost('package_id'));
            if($packages != false){
                $pack_delete = new Packages();
                $pack_delete->delete();
                $response->setJsonContent(array(
                    'data'  => $pack_delete->getMessages()
                ));
            }
            $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_NO_RENDER);
            $response->setHeader('Content-Type', 'application/json');
            $response->send();
        }
    }
    
    public function showAction(){
        $this->__dataTableJsCss();
        $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
    }
    
    protected function __dataTableFlow($builder){
        if($this->request->isAjax()){
            $dataTables = new \DataTables\DataTable();
            return $dataTables->fromBuilder($builder)->sendResponse();
        }
        //$this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_NO_RENDER);
    }
}
