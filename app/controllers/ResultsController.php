<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ResultsController
 *
 * @author web
 */
class ResultsController extends BaseController{
    private $_excelSingleResult;
    
    public function initialize() {
        parent::initialize();
        $this->view->setVars(array(
            'courses' => Course::find(),'depts' => Packages::find(
                    array(
                        'lecturer="'.$this->session->get('auth')['codename'].'"',
                        'group' => 'title'
                    )
                )
            )
        );
        $this->assets->collection('headers')
                ->addCss('assets/js/file-uploader/css/jquery.fileupload.css')
                ->addCss('assets/js/file-uploader/css/jquery.fileupload-ui.css');
        $this->assets->collection('footers')
                ->addJs('assets/js/file-uploader/js/jquery.fileupload-ui.js');
    }
    
    public function indexAction(){
        $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_LAYOUT);
    }
    
    public function uploadAjaxAction(){
        $inputFileName = '';
        //$inputFileType = 'Excel5';
	$inputFileType = 'Excel2007';
        if($this->request->hasFiles()){
            $file = $this->request->getUploadedFiles();
            $inputFileName = $file[0]->getTempName();
        }
        
        //$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
        $objReader      = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel    = $objReader->load($inputFileName);
        $sheetData      = $objPHPExcel->getActiveSheet()->toArray(null);
        $resultExcel = new Results();
        //Set the Response Variable using HTTP type
        $response = new Phalcon\Http\Response();
        $return = $resultExcel->__excelPostArray($sheetData, 'result');
        $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_NO_RENDER);
        $response->setHeader('Content-Type', 'application/json');
        $response->setJsonContent(array('return' => $return));
        
        $response->sendHeaders();
        $response->send();
    }
    /** result post pack 
    public function showAction(){
        if($this->request->isPost()){
            $packages = $this->modelsManager->createBuilder()
                    ->from('Packages')
                    ->where('session="'.$this->request->getPost('session').'"')
                    ->andWhere('department="'.$this->request->getPost('department').'"')
                    ->andWhere('lecturer="'.$this->session->get('auth')['codename'].'"')
                    ->andWhere('level="'.$this->request->getPost('level').'"');
            $this->view->setVar('packs', $packages->getQuery()->execute());
            $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_AFTER_TEMPLATE);
        }
    }
    **/
    
    public function showAction(){
        if($this->request->isPost()){
            $registered = CourseRegistration::find(array(
                "conditions"    => $this->__conditionsRemoveEmpty(),
                "bind"          => $this->__bindAfterRemoveEmpty(),
                "order"         => "matric DESC"
            ));
            if($registered != false){
                foreach($registered as $keys=>$values){
                    $full = Students::findFirstByMatric($values->matric);
                    $result = Results::findFirst(array(
                        'matric="'.$values->matric.
                        '" AND course="'.$values->code.'"'
                    ));
                    $cassess    = $result != false ? $result->ca : 0;
                    $scores     = $result != false ? $result->exam : 0;
                    $stackFlow[] = array(
                        'fullname'  => $full->surname.' '.$full->othernames,
                        'title'     => $values->title,
                        'code'      => $values->code,
                        'lecturer'  => $values->lecturer,
                        'department'=> $values->department,
                        'session'   => $values->session,
                        'matric'    => $values->matric,
                        'creg_id'   => $values->creg_id,
                        'ca'        => $result->ca,
                        'exam'      => $result->exam
                    );
                    //var_dump($registered->title); exit;
                }
                $this->view->setVars(array('packs' => $stackFlow));
                //var_dump($registered->title); exit;
            }
            $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_AFTER_TEMPLATE);
        }
    }
    
    public function postResultAction(){
        if($this->request->isPost()){
            $results = BaseModel::__getBMInst()->__postRawSQLTask(
                    $this->request->getPost(),'result','',BaseModel::MODEL_INSERT);
            if($results){
                $this->flash->success('<strong>Results for the class is uploaded</strong>');
                $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_AFTER_TEMPLATE);
            }
        }
        $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_NO_RENDER);
        $this->response->redirect('results/');
    }
    
    public function httpResultAction(){
        $response = new \Phalcon\Http\Response();
        if($this->request->isAjax() && $this->request->isPost()){
            $results = new Results();
            $stacks = $this->request->getPost('stacks');
            parse_str($this->request->getPost('serial'));
            
            //Use array_difference to separate assoc values
            foreach($stacks as $index => $elements){
                $coArray    = array('firstname','lastname','phone','department');
                $arrStack   = $elements + array('ca'=>$ca[$index],'exam'=>$exam[$index]);
                $flowStack[] = array_diff_key($arrStack, array_flip($coArray));
            }
            $toDel = array('title','level','session');
            //Remove the fields not found in the Result database 
            $this->component->helper->arrayTraverse($flowStack, $toDel);
            //User the replace method to replace scores based on the creg_id unique values
            if($results->__replaceRawSQL($flowStack,'result')){
                $response->setJsonContent(array(
                    'status'    => 'OK',
                ));
                $response->setRawHeader("HTTP/1.1 200 OK");
            }
            else{
                $response->setRawHeader("HTTP/1.1 404 ERROR");
                $response->setJsonContent(array(
                    'status'    => 'ERROR'
                ));
            }
            $response->setHeader("Content-Type", "application/json");
            $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_NO_RENDER);
            $response->send();
        }
    }
    
    public function viewAllLevelAction(){
        //Remove empty or _url on get Query
        $this->__getPostRemoveEmpty();
        
        if($this->request->getQuery('matric')){
            $matric = $this->request->getQuery('matric');
            $getDetails = CourseRegistration::find(array(
                "conditions"    => $this->__conditionsRemoveEmpty('get'),
                "bind"          => $this->__bindAfterRemoveEmpty('get'),
                "order"         => "level DESC",
            ));
            if($getDetails != false){
                foreach($getDetails as $keys => $values){
                    $result = Results::findFirst(array(
                        'matric="'.$values->matric.'" AND course="'.$values->code.'"'
                    ));
                    //Set the units of the courses registered
                    GradePoints::__setUnits($values->units);
                    
                    //Add the continuos asseemesnts and examscore
                    $totalScore = $result->ca + $result->exam;
                    $totalView[] = array(
                        'matric'    => $values->matric,
                        'code'      => $values->code,
                        'title'     => $values->title,
                        'units'     => $values->units,
                        'level'     => $values->level,
                        'status'    => $values->status,
                        'totalScore'=> $totalScore,
                        'gradePoint'=> GradePoints::__gradeParser(
                                $totalScore, $values->units),
                    );
                }
                $this->view->setVars(array(
                    'results'   => $totalView,
                    'totalGrade'=> GradePoints::__getTotalGrade(),
                    'weightedGr'=> GradePoints::__weightedGradeAvr(),
                    'totalUnitP'=> GradePoints::__getTotalUnitPass(),
                    'totalUnitF'=> GradePoints::__getTotalUnitFail(),
                    'totalUnits'=> GradePoints::__getTotalUnits()
                ));
            }
        }
        else{
            $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_NO_RENDER);
            $this->response->redirect('results/viewForm');
        }
        $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
    }
    
    public function viewRegsAction(){
        $listView = $this->modelsManager->createBuilder()
                ->from('Courseregistration')
                ->where('Courseregistration.department="'.$this->request->getQuery('department').'"')
                ->andWhere('Courseregistration.lecturer="'.$this->session->get('auth')['codename'].'"')
                ->andWhere('Courseregistration.session="'.$this->request->getQuery('session').'"')
                ->andWhere('Courseregistration.code="'.$this->request->getQuery('code').'"')
                ->orderBy('Courseregistration.c_id')->getQuery()->execute();
        //var_dump($listView); exit;
        if($listView != false){
            foreach($listView as $keys => $values){
                $full = Students::findFirstByMatric($values->matric);
                $result = Results::findFirst(array(
                    'matric="'.$values->matric.'" AND course="'.$values->code.'"'
                ));
                
                $cassess = $result != false ? $result->ca : 0;
                $scores  = $result != false ? $result->exam : 0;
                
                $listViewArrays[] = array(
                    'fullname'  => $full->firstname.' '.$full->lastname,
                    'matric'    => $values->matric,
                    'department'=> $values->department,
                    'codename'  => $full->codename,
                    'creg_id'   => $values->creg_id,
                    'title'     => $values->title,
                    'course'    => $values->code,
                    'ca'        => $cassess,
                    'exam'      => $scores
                );
            }
            $this->view->setVar('listView', $listViewArrays);
        }
        $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_AFTER_TEMPLATE);
    }
    
    public function postAction(){
        if($this->request->isPost()){
            $results = new Results();
            if($results->__postRawSQLTask($this->request->getPost(),
                    'result', '', BaseModel::MODEL_REPLACE)){
                $this->flash->success($this->request->getPost('course')[0]."'s Uploaded");
                $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_LAYOUT);
            }
            else{
                $this->flash->error($results->getMessages()->getMessage());
                $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_LAYOUT);
            }
        }
    }
    
    public function getOffersAction(){
        $stackFlow = array();
        if($this->request->isPost()){
            $this->__getPostRemoveEmpty();
            $registered = Courseregistration::find(array(
                "conditions"    => $this->__conditionsRemoveEmpty(),
                "bind"          => $this->__bindAfterRemoveEmpty()
            ));
            //var_dump($registered); exit;
            if($registered != false){
                foreach($registered as $keys=>$values){
                    $result = Results::findFirst(array(
                        'matric="'.$values->matric.'" AND course="'.$values->code.'"'
                    ));
                    $full = Students::findFirstByMatric($values->matric);
                    $stackFlow[] = array(
                        'full'          => $full->surname.' '.$full->othernames,
                        'totalScore'    => (int)$result->ca + (int)$result->exam,
                        'matric'        => $full->matric,
                        'course'        => $values->code,
                        'ca'            => $result->ca,
                        'exam'          => $result->exam,
                        'department'    => $values->department,
                    );
                }
                $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
                $this->view->setVars(array('flowStack'=>$stackFlow,
                    'printView'=>$this->request->getPost()));
                //$this->view->setTemplateAfter('viewForm');
            }
            else{
                $this->flash->error('<strong>No Registration for this Course</strong>');
                $this->response->redirect('results/viewForm/?type=false');
                return false;
            }
        }
    }
    
    //Handles the print view of the candidates
    public function printViewAction(){
        $this->__printViewCss();
        if($this->request->isGet()){
            $getPost = $this->request->getPost();
            $this->__getPostRemoveEmpty();
            $registered = CourseRegistration::find(array(
                "conditions"    => $this->__conditionsRemoveEmpty('get'),
                "bind"          => $this->__bindAfterRemoveEmpty('get')
            ));
            if($registered != false){
                foreach($registered as $keys=>$values){
                    $result = Results::findFirst(array(
                        'matric="'.$values->matric.'" AND course="'.$values->code.'"'
                    ));
                    $full = Students::findFirstByMatric($values->matric);
                    $stackFlow[] = array(
                        'full'          => $full->firstname.' '.$full->lastname,
                        'totalScore'    => (int)$result->ca + (int)$result->exam,
                        'matric'        => $full->matric,
                        'course'        => $values->code,
                        'ca'            => $result->ca,
                        'exam'          => $result->exam,
                        'department'    => $full->department,
                    );
                }
                $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
                $this->view->setVars(array('flowStack'=>$stackFlow));
                //$this->view->setTemplateAfter('viewForm');
            }
        }
        else{
            $this->flash->warning('<strong>Kindly make a selection</strong>');
            $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_NO_RENDER);
            $this->request->redirect('results/viewForm');
        }
    }
    
    public function viewFormAction(){
        if($this->request->isPost()){
            $rows = '';
            $this->__getPostRemoveEmpty();
            //var_dump($this->__bindAfterRemoveEmpty()); exit;
            $registered = CourseRegistration::find(array(
                "conditions"    => $this->__conditionsRemoveEmpty(),
                "bind"          => $this->__bindAfterRemoveEmpty(),
                "group"         => "matric"
            ));
            if($registered != false){
                foreach($registered as $keys => $values){
                    $student = Students::find('matric="'.$values->matric.'"')->getFirst();
                    $comArray[] = array(
                        'fullname'  => $student->firstname.' '.$student->lastname,
                        'matric'    => $values->matric,
                        'session'   => $values->session,
                        'department'=> $values->department,
                        'email'     => $student->email,
                        'phone'     => $student->phone
                    );
                }
                $this->view->setVars(array(
                    'comArray'  => $comArray
                ));
            }
            else{
                $this->flash->error("<strong>No Registered Students Now!</strong>");
                $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
            }
        }
        $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
    }
    
    public function viewAction(){
        $this->__viewStackFlow();
        $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
    }
    
    /**
     * Creating excel sheet Dynamically
     */
    //Array value should be preformatted for brevity
    public function createSinglePersonExcelSheetAction(array $array = NULL){
        $this->__viewStackFlow();
        
        $styleArray = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            )
        );

        $styleArray2 = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
         );
        
        $objectPHPExcel = $this->getDI()->get('PHPExcel');
        
        $objectPHPExcel->getDefaultStyle()->applyFromArray($styleArray2);
        
        $objectPHPExcel->getProperties()->setCreator("Examiner")->setLastModifiedBy("Examiner")->setTitle("Student Transcript")
                ->setSubject("Student Transcript")->setKeywords("office 2007 openxml php")->setCategory("Result Sheet");
        
        //PHPExcel_Shared_Font::setAutoSizeMethod(PHPExcel_Shared_Font::AUTOSIZE_METHOD_EXACT);
        
        foreach(range('A','Z') as $column_id){
            $objectPHPExcel->getActiveSheet()->getColumnDimension($column_id)->setAutoSize(true);
        }
        
        $objectPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setIndent(1);
        
        $objectPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
        
        $objectPHPExcel->setActiveSheetIndex(0);
        $objectPHPExcel->getActiveSheet()
                ->setCellValue('A1','#')
                ->setCellValue('B1','Description')
                ->setCellValue('C1','Code')->setCellValue('D1','Marks')
                ->setCellValue('E1','Units')->setCellValue('F1','GP')
                ->setCellValue('G1','WGP');
        
        $objectPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);
        
        $objectPHPExcel->getActiveSheet()->getPageSetup()
                ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
        $objectPHPExcel->getActiveSheet()->getPageSetup()
                ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        
        $counter = 2;
        $rangers = $this->__charIncStart('A','Z');
        foreach($this->_excelSingleResult as $keys => $values){
            $objectPHPExcel->getActiveSheet()->setCellValue($rangers[0].$counter, $keys+1);
            $objectPHPExcel->getActiveSheet()->setCellValue($rangers[1].$counter, ucwords($values['title']));
            $objectPHPExcel->getActiveSheet()->setCellValue($rangers[2].$counter, strtoupper($values['code']));
            $objectPHPExcel->getActiveSheet()->setCellValue($rangers[3].$counter, $values['score'] + $values['ca']);
            $objectPHPExcel->getActiveSheet()->setCellValue($rangers[4].$counter, $values['units']);
            $objectPHPExcel->getActiveSheet()->setCellValue($rangers[5].$counter, $values['grade']);
            $objectPHPExcel->getActiveSheet()->setCellValue($rangers[6].$counter, $values['grade'] * $values['units']);
            $objectPHPExcel->getActiveSheet()->getStyle('A'.$counter.':G'.$counter)->getFont()->setSize(10);
            $objectPHPExcel->getActiveSheet()->getStyle('D'.$counter.':G'.$counter)->applyFromArray($styleArray);
            $counter++;
        }
        
        $highestCol = $objectPHPExcel->getActiveSheet()->getHighestRow() + 2;
        
        //Setting the last floor variables 
        $objectPHPExcel->getActiveSheet()->setCellValue('B'.$highestCol, 'Units Taken');
        $objectPHPExcel->getActiveSheet()->setCellValue('C'.$highestCol, GradePoints::__getTotalUnits());
        $objectPHPExcel->getActiveSheet()->getStyle('B'.$highestCol,'C'.$highestCol)->getFont()->setBold(true);
        $objectPHPExcel->getActiveSheet()->getStyle('C'.$highestCol)->applyFromArray($styleArray);
        $highestCol = $highestCol+1;
        $objectPHPExcel->getActiveSheet()->setCellValue('B'.$highestCol, 'Units Passed');
        $objectPHPExcel->getActiveSheet()->setCellValue('C'.$highestCol, GradePoints::__getTotalUnitPass());
        $objectPHPExcel->getActiveSheet()->getStyle('B'.$highestCol,'C'.$highestCol)->getFont()->setBold(true);
        $objectPHPExcel->getActiveSheet()->getStyle('C'.$highestCol)->applyFromArray($styleArray);
        $highestCol = $highestCol+1;
        $objectPHPExcel->getActiveSheet()->setCellValue('B'.$highestCol, 'WPG');
        $objectPHPExcel->getActiveSheet()->setCellValue('C'.$highestCol, GradePoints::__getTotalGrade());
        $objectPHPExcel->getActiveSheet()->getStyle('B'.$highestCol,'C'.$highestCol)->getFont()->setBold(true);
        $objectPHPExcel->getActiveSheet()->getStyle('C'.$highestCol)->applyFromArray($styleArray);
        $highestCol = $highestCol+1;
        $objectPHPExcel->getActiveSheet()->setCellValue('B'.$highestCol, 'CGPA');
        $objectPHPExcel->getActiveSheet()->setCellValue('C'.$highestCol, GradePoints::__weightedGradeAvr());
        $objectPHPExcel->getActiveSheet()->getStyle('B'.$highestCol,'C'.$highestCol)->getFont()->setBold(true);
        $objectPHPExcel->getActiveSheet()->getStyle('C'.$highestCol)->applyFromArray($styleArray);
        
        //Creating the file with the write method
        $objectWriter = PHPExcel_IOFactory::createWriter($objectPHPExcel, 'Excel2007');
        $objectWriter->save('../excel_sheet/longsheet.xls');
        $filePath    = '../excel_sheet/longsheet.xls';
        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=\"".basename($filePath)."\"");
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        ob_clean(); flush(); 
        readfile($filePath);
        $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_NO_RENDER);
    }
    
    //Method was refactored for excel
    private function __viewStackFlow(){
        $studentFlow = '';
        $stackFlow = array();
        if($this->request->isGet()){
            $this->__getPostRemoveEmpty();
            
            $getQuery = $this->request->getQuery();
            if(array_key_exists('_url', $getQuery)){
                array_shift($getQuery);
            }
            $result = $this->__getArrayCon($getQuery);
            $registered = CourseRegistration::find(array(
                "conditions"    => $result[1],
                "bind"          => $result[0]
            ));
            if($registered != false){
                $student = Students::findFirstByMatric(
                        $this->request->getQuery('matric'));

                foreach($registered as $keys => $values){
                    $result = Results::findFirst(array(
                        'matric="'.$values->matric.'" AND course="'.$values->code.'"'
                    ));

                    $cassess = $result != false ? $result->ca : 0;
                    $scores  = $result != false ? $result->exam : 0;

                    $stackFlow[] = array(
                        'title'     => $values->title,
                        'code'      => $values->code,
                        'lecturer'  => $values->lecturer,
                        'session'   => $values->session,
                        'matric'    => $values->matric,
                        'level'     => $values->level,
                        'units'     => GradePoints::__setUnits($values->units),
                        'grade'     => GradePoints::__gradeParser(
                                       (int)$scores+$cassess, $values->units),
                        'ca'        => $cassess,
                        'score'     => $scores
                    );
                }
                $this->_excelSingleResult = $stackFlow;
                $this->view->setVars(array(
                    'stackFlow'     => $stackFlow,
                    'studentFlow'   => $student,
                    'totalUnits'    => GradePoints::__getTotalUnits(),
                    'totalGrade'    => GradePoints::__getTotalGrade(),
                    'totalUnitP'    => GradePoints::__getTotalUnitPass(),
                    'totalUnitF'    => GradePoints::__getTotalUnitFail(),
                    'weightedAvr'   => GradePoints::__weightedGradeAvr()
                ));
            }
            else{
                $this->flash->error("<strong>Student have not Registered</strong>");
                $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_LAYOUT);
            }
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
    protected function __conditionsRemoveEmpty($type='post', $array=array()){
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
            default :
                foreach($array as $key => $value){
                    $strings .= $key.' = :'.$key.': AND ';
                }
                return substr($strings,0,-4);
                break;
        }
    }
    
    private function __printViewCss(){
        $this->assets->collection('prints')
                ->addCss('assets/bs3/css/bootstrap.min.css" rel="stylesheet"')
                ->addCss('assets/css/bootstrap-reset.css')
                ->addCss('assets/font-awesome-4.3.0/css/font-awesome.css')
                ->addCss('assets/css/style.css')
                ->addCss('assets/css/style-responsive.css');
                //->addCss('assets/css/invoice-print.css');
    }
    
    //Built for the purpose of excel library cells
    public function __charIncStart($current='A', $stop='ZZZ'){
        $array = array($current);
        while($current != $stop){
            $array[] = ++$current;
        }
        return $array;
    }
}
