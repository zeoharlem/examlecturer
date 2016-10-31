<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CourseRegistrationController
 *
 * @author web
 */
class CourseregistrationController extends BaseController{
    public function initialize() {
        parent::initialize();
        \Phalcon\Tag::appendTitle('Check Registration');
        $this->view->setVars(array(
            'courses' => Course::find(),'depts' => Packages::find(
                    array(
                        'lecturer="'.$this->session->get('auth')['codename'].'"',
                        'group' => 'title'
                    )
                )
            )
        );
    }
    
    public function indexAction(){
        
    }
    
    public function getPackageAction(){
        $response = new Phalcon\Http\Response();
        if($this->request->isPost() && $this->request->isAjax()){
            $parameter = 'session="'.$this->request->getPost('session').'" AND semester="'.
                    $this->request->getPost('semester').'" AND department="'.
                    $this->request->getPost('department').'" AND level="'.
                    $this->request->getPost('level').'"';
            
            $getPacks = Packages::find($parameter)->toArray();
            
            if($getPacks != false){
                $courseRegs = new CourseRegistration();
                foreach($getPacks as $keys => $values){
                    $register[] = $values + array('matric'=>$this->request->getPost('matric'));
                }
                $return = $courseRegs->__postIntKeyRaw($register, 'courseregistration');
                if($return != false){
                    $response->setJsonContent(array(
                        'status'    => 'OK',
                        'data'      => array(
                            'firstname' => Students::find('matric="'.
                                    $this->request->getPost('matric').'"')->getFirst()->firstname,
                            'level'     => $this->request->getPost('level'),
                            'department'=> $this->request->getPost('department'),
                            'session'   => $this->request->getPost('session')
                        ),
                        'message'   => $courseRegs->getMessages()
                    ));
                }
                else{
                    $response->setJsonContent(array(
                        'status'    => 'ERROR',
                        'message'   => $courseRegs->getMessages()
                    ));
                }
            }
            else{
                $response->setJsonContent(array(
                    'status'    => 'ERROR',
                    'message'   => $this->component->helper->getMsgReturn()
                ));
            }
        }
        $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_NO_RENDER);
        $response->setHeader("Content-Type", "application/json");
        $response->send();
    }
    
    public function downloadAction(){
        $totalRegister = array();
        if($this->request->isPost()){
            $this->__getPostRemoveEmpty();
            $coureregistered = Courseregistration::find(array(
                "conditions"    => $this->__conditionsRemoveEmpty(),
                "bind"          => $this->__bindAfterRemoveEmpty()
            ))->toArray();
    
            if($coureregistered != false){
                foreach($coureregistered as $keys => $values){
                    $results = Results::find(array('matric="'.$values['matric'].
                        '" AND course="'.$values['code'].'"'))->toArray();

                    //Set default scores and cas if found in the database to excel
                    $scores  = $results != false ? $results[0]['exam'] : 0;
                    $cassess = $results != false ? $results[0]['ca'] : 0;

                    $totalRegister[] = array(
                        'matric'    => $values['matric'],
                        'course'    => $values['code'],
                        'ca'        => $cassess,
                        'exam'      => $scores,
                        'creg_id'   => $values['creg_id'],
                        'title'     => $values['title']
                    );
                }
                
                $this->__getRegisteredExcel($totalRegister);
                $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_NO_RENDER);
                return true;
            }
            else{
                $this->flash->error('<strong>No Registration Found</strong>');
                $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_AFTER_TEMPLATE);
                return false;
            }
        }
        $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_AFTER_TEMPLATE);
    }
    
    private function __getRegisteredExcel(array $courseRegister){
        $writerType = 'Excel2007';
        $response = new Phalcon\Http\Response();
        $objectPHPExcel = $this->getDI()->get('PHPExcel');
        $styleArray = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            )
        );

        $styleArray2 = array(
            'borders'   => array(
                'allborders' => array(
                    'style'     => PHPExcel_Style_Border::BORDER_THIN
                )
            ),
            'alignment' => array(
                'horizontal'    => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            )
        );
        $counter = 2;
        //Start the creation and the format of the excel file
        PHPExcel_Shared_Font::setAutoSizeMethod(PHPExcel_Shared_Font::AUTOSIZE_METHOD_EXACT);
        
        $objectPHPExcel->getDefaultStyle()->applyFromArray($styleArray2);
        
        $objectPHPExcel->getProperties()->setCreator("Examiner")->setLastModifiedBy("Examiner")
                ->setKeywords("office 2007 openxml php")->setCategory("Result Sheet")
                ->setTitle("Student Transcript")->setSubject("Student Transcript");
        
        $objectPHPExcel->setActiveSheetIndex(0);
        
        $objectPHPExcel->getActiveSheet()->setCellValue('A1','matric')->setCellValue('B1','course')
                ->setCellValue('C1','ca')->setCellValue('D1','exam')->setCellValue('E1','creg_id');
        
        foreach($courseRegister as $keys => $values){
            $objectPHPExcel->getActiveSheet()->setCellValue('A'.$counter, $values['matric']);
            $objectPHPExcel->getActiveSheet()->setCellValue('B'.$counter, $values['course']);
            $objectPHPExcel->getActiveSheet()->setCellValue('C'.$counter, $values['ca']);
            $objectPHPExcel->getActiveSheet()->setCellValue('D'.$counter, $values['exam']);
            $objectPHPExcel->getActiveSheet()->setCellValue('E'.$counter, $values['creg_id']);
            $counter++;
        }
        $text = $courseRegister[0]['course'].'_'.$courseRegister[0]['title'];
        
        $fileNew     = preg_replace('#[ -]+#', '-', $text);
        $filePath    = '../excel_sheet/'.$fileNew.'.xls';
        
        $objectWriter = PHPExcel_IOFactory::createWriter($objectPHPExcel, $writerType);
        $objectWriter->save($filePath);
        
        $this->__setHeaderNotify($filePath);
        ob_clean(); flush(); 
        readfile($filePath);
    }
    
    /**
     * Set Header to be sent to the browser
     * @param type $filePath
     */
    private function __setHeaderNotify($filePath){
        $response = new Phalcon\Http\Response();
        //$response->setHeader('Content-Type','application/vnd.ms-excel');
        $response->setHeader('Content-Type','application/octet-stream');
        $response->setHeader("Content-Disposition","attachment;filename=".basename($filePath));
        
        // If you're serving to IE over SSL, then the following may be needed
        $response->setHeader('Expires','Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        $response->setHeader('Last-Modified',gmdate('D, d M Y H:i:s').' GMT'); // always modified
        $response->setHeader('Cache-Control','cache, must-revalidate'); // HTTP/1.1
        $response->setHeader('Content-Length', filesize($filePath));
        $response->setHeader('Pragma','public'); // HTTP/1.0
        $response->sendHeaders();
    }
}
