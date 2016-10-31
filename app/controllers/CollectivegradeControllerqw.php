<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CollectivegradeController
 *
 * @author web
 */
class CollectivegradeController extends BaseController{
    private $_classLevels = array(100,200,300,400);
    
    public function initialize(){
        parent::initialize();
        $this->view->setVars(array(
            'courses' => Course::find(),'depts' => Departments::find())
        );
    }
    
    public function indexAction(){
        if($this->request->isPost()){
            $this->__collectiveHTMLExcelSheet($this->request->getPost(), 
                    'http://localhost/examiner/collectiveGrade/collective');
        }
        $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_LAYOUT);
    }
    
    public function collectiveAction(){
        $this->__printViewCss();
        $folder = $_SERVER['DOCUMENT_ROOT'].'/excel_sheet/collective.html';
        $regStudents = $this->__getRegisterStudents($this->request->getPost());
        if($regStudents != false){
            foreach($regStudents as $keys=>$values){
                $fullname = Students::findFirstByMatric($values['matric']);
                $register[] = array(
                    'fullname'  => $fullname->firstname.' '.$fullname->lastname,
                    'matric'    => $values['matric'], 'level' => $values['level']
                );
            }
        }
        $this->view->setVars(array(
            'regStudents'   => $register,
            'collective'    => $this,
            'regCourses'    => $this->__getPackageCourses($this->request->getPost()),
            'gradePointer'  => new GradePoints()
        ));
        $this->__createFromCopy('http://localhost/examiner/collectivegrade/collective', $folder);
        $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
    }
    
    //Try calculating the CGPA for the session
    public function __getOtherSemester($typeArray){
        $register = $this->__getPagifyBuilder($typeArray);
        
        foreach($register as $keys => $values){
            $results = $this->__getResults(array(
                'matric'    => $values->matric,
                'course'    => $values->code
            ));
            $grade = GradePoints::__gradeParser($results[0]['exam'], $values->units);
            $units = GradePoints::__setUnits($values->units);
        }
        //var_dump(GradePoints::__getTotalGrade());
    }
    
    //Calculate the CGPA for the whole semester
    //The class grade is based on the level found registered for
    public function __getAllSemester($typeArray){
        $register = $this->__getAllLevelRegister($typeArray);
        foreach($register as $keys => $values){
            //var_dump($values); exit;
            foreach($values as $index => $elements){
                $results = $this->__getResults(array(
                    'matric' => $elements['matric'], 'course' => $elements['code']
                ));
                GradePoints::__gradeParser($results[0]['exam'], $elements['units']);
                GradePoints::__setUnits($elements['units']);
            }
        }
    }
    
    //Needed to be refactored for excel purpose
    public function getTotalStudentAction(){
        if($this->request->isPost()){
            $students = $this->__getRegisterStudents($this->request->getPost());
            $this->__collectiveExcelSheet($this->request->getPost());
        }
    }
    
    //Create excel sheet from HTML table
    private function __collectiveHTMLExcelSheet(array $array, $loader){
        $gradePoints = new GradePoints();
        $writerType = 'Excel2007';
        $response = new Phalcon\Http\Response();
        $objectPHPExcel = $this->getDI()->get('PHPExcel');
        $objectPHPExcelReader = PHPExcel_IOFactory::createReader('HTMl');
        $objectPHPExcel = $objectPHPExcelReader->load($loader);
        $objectPHPExcelWriter = PHPExcel_IOFactory::createWriter($objectPHPExcel, $writerType);
        $objectPHPExcelWriter->save('../excel_sheet/class.xlsx');
    }
    
    //Create excel sheet from the database and manipulate it
    private function __collectiveExcelSheet(array $array){
        $gradePoints = new GradePoints();
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
        
        //Start the creation and the format of the excel file
        PHPExcel_Shared_Font::setAutoSizeMethod(PHPExcel_Shared_Font::AUTOSIZE_METHOD_EXACT);
        
        $objectPHPExcel->getDefaultStyle()->applyFromArray($styleArray2);
        
        $objectPHPExcel->getProperties()->setCreator("Examiner")->setLastModifiedBy("Examiner")->setTitle("Student Transcript")
                ->setSubject("Student Transcript")->setKeywords("office 2007 openxml php")->setCategory("Result Sheet");
        
        foreach(range('A','Z') as $column_id){
            $objectPHPExcel->getActiveSheet()->getColumnDimension($column_id)->setAutoSize(true);
        }
        $objectPHPExcel->setActiveSheetIndex(0);
        $objectPHPExcel->getActiveSheet()->setCellValue('A5','S/N')
                ->setCellValue('B5','MATRIC NO')->setCellValue('C5','NAME OF CANDIDATES')
                ->setCellValue('D5','SEX');
        
        //Set Up vars for loop use;
        $counter = 6; $ncounts = 0; $icounts = 0;
        $rCounter=6; $scount = 0; $stackFlow = array();$curr = 0;
        $rangers = $this->__charIncStart('E','CC');
        $firstArray = array('GRADE','NUP');
        $firstArray2 = array('TNU','TCP','GPA');
        $currentPosition = '';
        
        //var_dump($rangers); exit;
        /**
         * Get the course packaged for each semester
         * The results must be in array for brevity
        */
        $packages = $this->__getPackageCourses($array);
        
        //Get registered students and group together by matric
        $registered = $this->__getRegisterStudents($array);
        //reset($rangers);
        //Create a loop to fix each student's details in cell
        //$startR = $this->__charIncStart('A', 'D');
        foreach($registered as $rkeys => $rvalues){
            //A quick search of the student using matric number
            $name = Students::findFirstByMatric($rvalues['matric']);
            $fullname = strtoupper($name->firstname.' '.$name->lastname);
            
            //Set cell values into appropriate cells
            $objectPHPExcel->getActiveSheet()->setCellValue('A'.$counter,$rkeys+1);
            $objectPHPExcel->getActiveSheet()->setCellValue('B'.$counter,'SCI/12/13/'.$rvalues['matric']);
            $objectPHPExcel->getActiveSheet()->setCellValue('C'.$counter, $fullname);
            $objectPHPExcel->getActiveSheet()->setCellValue('D'.$counter,'M');
            
            //Get the results of each student using matric and course code
            foreach($packages as $pkeys=>$pvalues){
                //$rangers = $this->__charIncStart('E','CC');
                $stackFlow = $this->__getResults(array(
                    'matric'    => $rvalues['matric'],
                    'course'    => $pvalues['code']
                ));
                
                $totalScore = @$stackFlow[0]['exam'] + @$stackFlow[0]['ca'];
                
                $grade      = GradePoints::__gradeParser($totalScore, $pvalues['units']);
                $nup        = $grade * $pvalues['units'];
                $totalUnits = GradePoints::__getTotalUnits();
                $totalUnitP = GradePoints::__getTotalUnitPass();
                $totalUnitF = GradePoints::__getTotalUnitFail();
                $totalGrade = GradePoints::__getTotalGrade();
                $totalWGP   = GradePoints::__weightedGradeAvr();
                
                //$setc[$rkeys][] = $rangers[$scount].$rCounter;
                $objectPHPExcel->getActiveSheet()->setCellValue($rangers[$scount].$rCounter, $totalScore);
                $objectPHPExcel->getActiveSheet()->setCellValue($rangers[$scount+1].$rCounter, $grade);
                $objectPHPExcel->getActiveSheet()->setCellValue($rangers[$scount+2].$rCounter, $nup);
                //$currentPosition = $rangers[$rkeys+$curr];
                //$objectPHPExcel->getActiveSheet()->setCellValue($rangers[$rkeys+$curr].$rCounter, $totalUnits);
                $scount += 3;
                //$curr++;
            }
            $curr = 3;
            
            //Alwasy restore back to 0 to start from the top again
            $scount = 0;
            //Increase counter;
            $rCounter++;
            //Increase counter;
            $counter++;
        }
        
//        var_dump($currentPosition);
//        exit;
        //Loop throught the packaged courses returned and set them in three set apiece
        foreach($packages as $keys=>$values){
            
            //$currentPosition = $rangers[$keys];
            $objectPHPExcel->getActiveSheet()->setCellValue($rangers[$ncounts].'4',$values['units'].'UNITS');
            $objectPHPExcel->getActiveSheet()->setCellValue($rangers[$ncounts].'5',  strtoupper($values['code']));
            
            //This loop formats for the Grade, Number of units passed
            for($i = 0; $i < count($firstArray); $i++){
                $objectPHPExcel->getActiveSheet()->setCellValue($rangers[$icounts+$keys+1].'5',$firstArray[$i]);
                
                $currentPosition = $rangers[$icounts+$keys+2];
                $icounts += 1;
            }
            
            //This loop formats for the TNU, TCP, GPA
            foreach($firstArray2 as $nkeys => $nvalues){
                $currPos = PHPExcel_Cell::columnIndexFromString($currentPosition);
                $currStrPos = PHPExcel_Cell::stringFromColumnIndex($currPos - 1 + $nkeys);
                $objectPHPExcel->getActiveSheet()->setCellValue($currStrPos.'5',$nvalues);
            }
            $ncounts += 3;
        }
        //var_dump($currentPosition.'5'); exit;
        
        $filePath    = '../excel_sheet/class.xls';
        
        $objectWriter = PHPExcel_IOFactory::createWriter($objectPHPExcel, 'Excel2007');
        $objectWriter->save($filePath);
        
        $this->__setHeaderNotify($filePath);
        ob_clean(); flush(); 
        readfile($filePath);
        $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_NO_RENDER);
    }
    
    private function __createFromCopy($file,$folder){
//        $file_get_contents = file_get_contents($file);
//        if($file_get_contents != false){
//            file_put_contents($folder, $file_get_contents);
//        }
        var_dump(copy($file, $folder)); exit;
    }
    
    //Built for the purpose of excel library cells
    private function __charIncStart($current='A', $stop='ZZZ'){
        $array = array($current);
        while($current != $stop){
            $array[] = ++$current;
        }
        return $array;
    }
    
    /**
     * @param array $getPost
     */
    private function __getPackageCourses(array $getPost){
        $packages = Packages::find(array(
            "conditions"    => $this->__typeAdjustCondition($getPost),
            "group"         => 'code'
        ));
        return $packages->toArray();
    }
    
    /**
     * Get student results.
     * This method has been duplicated
     * consider refactoring the line of codes
     * @param array $array
     * @return type
     */
    public function __getResults(array $array){
        $results = Results::find(array(
            "conditions"    => $this->__typeAdjustCondition($array),
            "limit"         => 1
        ));
        return $results->toArray();
    }
    
    /**
     * Set Header to be sent to the browser
     * @param type $filePath
     */
    private function __setHeaderNotify($filePath){
        $response = new Phalcon\Http\Response();
        $response->setHeader('Content-Type','application/vnd.ms-excel');
        $response->setHeader("Content-Disposition","attachment;filename=\"".basename($filePath)."\"");
        $response->setHeader('Cache-Control','max-age=0');
        // If you're serving to IE 9, then the following may be needed
        $response->setHeader('Cache-Control','max-age=1');
        // If you're serving to IE over SSL, then the following may be needed
        $response->setHeader('Expires','Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        $response->setHeader('Last-Modified',gmdate('D, d M Y H:i:s').' GMT'); // always modified
        $response->setHeader('Cache-Control','cache, must-revalidate'); // HTTP/1.1
        $response->setHeader('Pragma','public'); // HTTP/1.0
        $response->sendHeaders();
    }
    
    //Refactoriing purpose the getRegisterStidents
    /**
     * @param array $requestType
     * @return array
     */
    private function __getRegisterStudents(array $requestType){
        $students = CourseRegistration::find(array(
            "conditions"    => $this->__typeAdjustCondition($requestType),
            "group"         => 'matric'
        ));
        return $students->toArray();
    }
    
    //Refactoriing purpose the getRegisterStidents
    /**
     * @param array $requestType
     * @return array
     */
    private function __getRegisterCourse(array $requestType){
        $students = CourseRegistration::find(array(
            "conditions"    => $this->__typeAdjustCondition($requestType),
        ));
        return $students->toArray();
    }
    
    //Refactoriing purpose the __typeAdjustCondition
    /**
     * @param array $typeRequest
     * @return string
     */
    private function __typeAdjustCondition(array $typeRequest){
        $stringArray = '';
        foreach($typeRequest as $keys => $values){
            $stringArray .= $keys." = '".$values."' AND ";
        }
        return substr($stringArray, 0, -4);
    }
    
    //Use this to get other semesters 
    //For brevity the conditions where specific
    //This method can be more flexible by making the conditions vars
    private function __getPagifyBuilder(array $array){
        $builder = $this->modelsManager->createBuilder();
        if(array_key_exists('semester', $array)){
            unset($array['semester']);
        }
        $builder->from('Courseregistration')
                ->where('Courseregistration.level="'.$array['level'].'"')
                ->andWhere('Courseregistration.matric="'.$array['matric'].'"');
        return $builder->getQuery()->execute();
    }
    
    //Get the all level course registered by candidates
    private function __getAllLevelRegister(array $array){
        $resultReturn = array();
        foreach($this->_classLevels as $values){
            $regCourses = $this->__getRegisterCourse(array_merge(
                    $array, array(
                        'level'=>$values
                    )));
            if($regCourses != false){
                $resultReturn[] = $regCourses;
            }
        }
        return $resultReturn;
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
}
