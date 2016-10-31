<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BaseController
 *
 * @author web
 */
class BaseController extends Phalcon\Mvc\Controller{
    public function initialize(){
        \Phalcon\Tag::prependTitle('School Portal | ');
        
        $this->view->selectSession = $this->__selectSession();
        
        $this->assets->collection('headers')
                ->addCss('assets/bs3/css/bootstrap.min.css')
                ->addCss('assets/css/bootstrap-reset.css')
//                ->addCss('assets/css/purple-theme.css')
                //->addCss('assets/font-awesome/css/font-awesome.css')
                ->addCss('assets/font-awesome-4.3.0/css/font-awesome.css')
                //->addCss('http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600', true)
                ->addCss('assets/css/style.css')
                ->addCss('assets/css/style-responsive.css');
        
        $this->assets->collection('footers')
                ->addJs('assets/js/jquery.js')
                ->addJs('assets/js/jquery-1.8.3.min.js')
                ->addJs('assets/bs3/js/bootstrap.min.js')
                ->addJs('assets/js/jquery.dcjqaccordion.2.7.js')
                ->addJs('assets/js/jquery.scrollTo.min.js')
                ->addJs('assets/js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js')
                ->addJs('assets/js/jquery.nicescroll.js')
                ->addJs('assets/js/scripts.js')
                ->addJs('assets/js/app.js');
    }
    
    public function __dataTableJsCss(){
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
    
    public function __selectSession(){
        $select = '';
        for($start=2012,$end=2013; $start < date('Y'); $start++, $end++){
            $select .= '<option value="'.$start.'/'.$end.'">'.$start.'/'.$end.'</option>';
        }
        return $select;
    }
    
    protected function __dataTableFlow($builder){
        if($this->request->isAjax()){
            $dataTables = new \DataTables\DataTable();
            return $dataTables->fromBuilder($builder)->sendResponse();
        }
    }
    
    //Get Array Conditions to replace post or get Query
    //Note that the index 0 returned is array and 1 is strings
    //Use like this $getWhatever = $this->__getArrayCon($array);
    protected function __getArrayCon(array $array){
        $strings = '';
        $results = array();
        foreach($array as $key => $value){
            $results[$key] = $value;
            $strings .= $key.' = :'.$key.': AND ';
        }
        return array(
            $results, substr($strings,0,-4)
        );
    }
    
    //Remove empty getPost() | getQuery() request
    protected function __getPostRemoveEmpty(){
        if($this->request->isPost()){
            foreach($this->request->getPost() as $key => $value){
                if(empty($value) || is_null($value)){
                    unset($_POST[$key]);
                }
            }
        }
        else{
            foreach($this->request->getQuery() as $key => $value){
                if(empty($value) || is_null($value)){
                    unset($_GET[$key]);
                }
            }
        }
    }
    
    //This method create a binding value based
    //Empty post remooved from the getPost() returned
    protected function __bindAfterRemoveEmpty($type='post'){
        $results = array();
        switch ($type) {
            case 'post':
                foreach($this->request->getPost() as $key => $value){
                    $results[$key] = $value;
                }
                return $results;
                break;
                
            case 'get':
                foreach($this->request->getQuery() as $key => $value){
                    if($key !== '_url'){
                        $results[$key] = $value;
                    }
                }
                return $results;
                break;
        }
    }
    
    //This method creates queries of values for binding
    protected function __conditionsRemoveEmpty($type='post'){
        $strings = '';
        switch ($type) {
            case 'post':
                foreach($this->request->getPost() as $key => $value){
                    $strings .= $key.' = :'.$key.': AND ';
                }
                return substr($strings,0,-4);
                break;
                
            case 'get':
                foreach($this->request->getQuery() as $key => $value){
                    if($key !== '_url'){
                        $strings .= $key.' = :'.$key.': AND ';
                    }
                }
                return substr($strings,0,-4);
                break;
        }
    }
    
}
