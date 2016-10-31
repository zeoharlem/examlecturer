<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GradePoints
 *
 * @author web
 */
class GradePoints extends Phalcon\Mvc\Model{
    const DEFAULT_LIMIT = 39;
    //private static $_INSTANCE;
    private static $_grades, $_units, $_totalUnits, 
            $_totalUnitsPass, $_totalUnitsFail, $_totalGrade;
    private static $_remarks = array(), $_strVar;
    
    //Test the score and assign corresponding grades
    public static function __gradeParser($score,$unit,$code=''){
        if($score >= 69){
            self::$_grades = 5;
            self::$_totalGrade[] = self::$_grades*$unit;
            self::__setUnitPF($score, $unit);
        }
        if($score > 59 && $score < 69){
            self::$_grades = 4;
            self::$_totalGrade[] = self::$_grades*$unit;
            self::__setUnitPF($score, $unit);
        }
        if($score > 49 && $score < 59){
            self::$_grades = 3;
            self::$_totalGrade[] = self::$_grades*$unit;
            self::__setUnitPF($score, $unit);
        }
        if($score > 44 && $score < 50){
            self::$_grades = 2;
            self::$_totalGrade[] = self::$_grades*$unit;
            self::__setUnitPF($score, $unit);
        }
        if($score > 39 && $score < 45){
            self::$_grades = 1;
            self::$_totalGrade[] = self::$_grades*$unit;
            self::__setUnitPF($score, $unit);
        }
        if($score >= 0 && $score < 40){
            self::$_grades = 0;
            self::$_totalGrade[] = self::$_grades*$unit;
            self::__setUnitPF($score, $unit);
        }
        self::__setRemarks($code, $score);
        return self::$_grades;
    }
    
    //returns static strVar
    public static function __strVar($score){
        if($score >= 69){
            self::$_strVar = 'A1';
        }
        elseif($score > 59 && $score < 69){
            self::$_strVar = 'B4';
        }
        elseif($score > 49 && $score < 59){
            self::$_strVar = 'C3';
        }
        elseif($score > 44 && $score < 50){
            self::$_strVar = 'D2';
        }
        elseif($score > 39 && $score < 45){
            self::$_strVar = 'E1';
        }
        elseif($score >= 0 && $score < 40){
            self::$_strVar = 'F0';
        }
        return self::$_strVar;
    }
    
    //Set remarks to self::$_remarks
    public static function __setRemarks($code, $score){
        if($score <= self::DEFAULT_LIMIT){
            self::$_remarks[] = $code;
        }
    }
    
    public static function __getArrayRemarks(){
        return self::$_remarks;
    }
    
    //Compare the values found in the carry over and normal
    public static function __remarkFlow($array1, $array2){
        return array_diff($array1, $array2);
    }
    
    public static function __getRemarks(){
        return join(',', self::$_remarks);
    }

    //Add up the stored grades in totalgrade
    //It will be better for @method to be tested if null
    public static function __getTotalGrade(){
        return @array_sum(self::$_totalGrade);
    }
    
    //Public set up the units values to array
    public static function __setUnits($units){
        self::$_units[] = $units;
        return $units;
    }
    
    //Sum up the store values in array units
    public static function __getTotalUnits(){
        return self::$_totalUnits = !is_null(self::$_units) ? array_sum(self::$_units) : 0;
    }
    
    //Sum up the total units passed _totalUnitPass
    public static function __getTotalUnitPass(){
        return !is_null(self::$_totalUnitsPass) ? array_sum(self::$_totalUnitsPass) : 0;
    }
    
    //Sum up the total units failed _totalUnitFail
    public static function __getTotalUnitFail(){
        return !is_null(self::$_totalUnitsFail) ? array_sum(self::$_totalUnitsFail) : 0;
    }
    
    //Calculate the weighted grade average
    public static function __weightedGradeAvr(){
        if(self::__getTotalUnits() == 0){
            $totlWeightedAvr = 0;
        }
        else{
            $totlWeightedAvr = self::__getTotalGrade() / self::__getTotalUnits();
        }
        return number_format($totlWeightedAvr, 2, '.', '');
    }
    
    //Set array stored in vars to null
    //Use this method when dealing with the whole class
    public static function __clearSetArray(){
        self::$_units = array();
        self::$_totalGrade = array();
        self::$_totalUnitsFail = array();
        self::$_totalUnitsPass = array();
        self::$_remarks = array();
    }
    
    public static function __getResults(array $array){
        $results = Results::find(array(
            "conditions"    => self::__typeAdjustCondition($array),
            "limit"         => 1
        ));
        return $results->toArray();
    }
    
    public static function __resetRemark($remark, $score){
        if($score > self::DEFAULT_LIMIT){
            if(($key = array_search($remark, self::$_remarks)) !== false){
                unset(self::$_remarks[$key]);
            }
        }
        return join(',', self::$_remarks);
    }

    //Refactoriing purpose the __typeAdjustCondition
    /**
     * @param array $typeRequest
     * @return string
     */
    private static function __typeAdjustCondition(array $typeRequest){
        $stringArray = '';
        foreach($typeRequest as $keys => $values){
            $stringArray .= $keys." = '".$values."' AND ";
        }
        return substr($stringArray, 0, -4);
    }

    //Set units passed and failed to array value vars
    /**
     * public static function __getPassed($key){
        return self::$_totalUnitsPass[$key];
    }**/
    
    //Set units passed and failed to array value vars
    private static function __setUnitPF($score, $unit){
        if($score > self::DEFAULT_LIMIT){
            self::$_totalUnitsPass[] = $unit;
        }
        elseif($score <= self::DEFAULT_LIMIT){
            self::$_totalUnitsFail[] = $unit;
        }
    }
}
