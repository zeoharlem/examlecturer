<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DepartmentResultsController
 *
 * @author WEB
 */
class DepartmentResultsController extends BaseController{
    private $_classLevels = array(100,200,300,400);
    
    public function initialize() {
        parent::initialize();
        Phalcon\Tag::appendTitle('Department Results');
    }
    
    public function indexAction(){
        $this->view->setTemplateAfter('deptresults');
    }
    
    public function showAction(){
        if($this->request->isPost()){
            $this->view->setVars(array(
                'packages'  => $this->__getPackageCourse(),
                'previous'  => $this->__getPreviousResults(),
                'cummulate' => $this->__getTogetherResults(),
                'viewList'  => $this->__showListMaker()
            ));
        }
        $this->view->setTemplateAfter('deptresults');
    }
    
    private function __getPreviousResults(){
        $stackFlow = array(); $carryFlow = array();
        $courseRegs = Courseregistration::find(array(
            'conditions'   => $this->__conditionsRemoveEmpty(),
            'bind'         => $this->__bindAfterRemoveEmpty(),
            'limit'        => 3
        ));
        $carryRegs = Carryover::find(array(
            'conditions'   => $this->__conditionsRemoveEmpty(),
            'bind'         => $this->__bindAfterRemoveEmpty(),
            'limit'        => 3
        ));
        
        foreach($courseRegs as $key => $value){
            GradePoints::__setUnits($value->units);
            $score = (int) $courseRegs[$key]->results->exam
                    + (int)$courseRegs[$key]->results->ca;
            GradePoints::__gradeParser($score, $value->units);
            
            $stackFlow[] = array(
                'scores'        => $score,
                'course'        => @$value->code,
                'matric'        => @$value->matric,
                'totalUnits'    => GradePoints::__getTotalUnits(),
                'totalUnitFail' => GradePoints::__getTotalUnitFail(),
                'totalUnitPass' => GradePoints::__getTotalUnitPass(),
                'totalGrade'    => GradePoints::__getTotalGrade(),
                'weightedAvr'   => GradePoints::__weightedGradeAvr(),
            );
            //GradePoints::__clearSetArray();
        }
        if($carryRegs !== false){
            foreach($carryRegs as $key => $value){
                GradePoints::__setUnits($value->units);
                $score = (int) @$carryRegs[$key]->resultCarry->exam
                        + (int)@$carryRegs[$key]->resultCarry->ca;
                GradePoints::__gradeParser($score, $value->units);

                $carryFlow[] = array(
                    'scores'        => $score,
                    'course'        => @$value->code,
                    'matric'        => @$value->matric,
                    'totalUnits'    => GradePoints::__getTotalUnits(),
                    'totalUnitFail' => GradePoints::__getTotalUnitFail(),
                    'totalUnitPass' => GradePoints::__getTotalUnitPass(),
                    'totalGrade'    => GradePoints::__getTotalGrade(),
                    'weightedAvr'   => GradePoints::__weightedGradeAvr(),
                );
            }
            return array_merge($stackFlow, $carryFlow);
        }
        GradePoints::__clearSetArray();
        return $stackFlow;
    }
    
    private function __getTogetherResults(){
        
    }
    
    private function __getPackageCourse(){
        return Packages::find(array(
            'conditions'    => $this->__conditionsRemoveEmpty(),
            'bind'          => $this->__bindAfterRemoveEmpty()
        ))->toArray();
    }
    
    private function __showListMaker($type='post'){
        $register = array();
        switch($type){
            case 'post':
                $register = Courseregistration::find(array(
                    'conditions'    => $this->__conditionsRemoveEmpty(),
                    'bind'          => $this->__bindAfterRemoveEmpty()
                ))->toArray();
                break;
            case 'get':
                $register = Courseregistration::find(array(
                    'conditions'    => $this->__conditionsRemoveEmpty('get'),
                    'bind'          => $this->__bindAfterRemoveEmpty('get')
                ))->toArray();
                break;
            default:
                $register = Courseregistration::find(array(
                    'conditions'    => $this->__conditionsRemoveEmpty(),
                    'bind'          => $this->__bindAfterRemoveEmpty()
                ))->toArray();
                break;
        }
        return $register;
    }
    
    private function __cutLevels($current, $pos=0){
        return array_slice($this->_classLevels, 0,
                array_search($current, $this->_classLevels) + $pos);
    }
}
