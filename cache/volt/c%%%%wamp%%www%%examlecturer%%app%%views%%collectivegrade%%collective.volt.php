<!DOCTYPE html>
<html class="no-js" lang="en">
    <head>
        
        <meta charset="utf-8">
        <title>School Portal</title>
        <meta content="IE=edge" http-equiv="X-UA-Compatible">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        
        <?php echo $this->assets->outputCss('prints'); ?>
        
        
        <link href="favicon.ico" rel="shortcut icon">
<style type="text/css">
            @media print{
                .table{
                    border-collapse: collapse !important;
                }
                .noprint{
                    display: none !important;
                }
                
                @page {
                    size: landscape;
                }
                
                td{
                    white-space: nowrap;
                    border: 1px solid #aaa;
                    font-size:10px !important;
                }
                
                th.rotates{
                    height: 190px;
                    white-space: nowrap;
                }

                th.rotates > div{
                    transform: translate(25px, 51px)rotate(-90deg);
                    width:10px !important;
                    
                }

                th.rotates > div > span{
    /*                border: 1px solid #ccc;*/
                }
            }
            .table{
                border-collapse: collapse !important;
            }
            td{
                white-space: nowrap;
                border-collapse: collapse !important;
            }
            th{
                background-color: none !important;
            }
            th.rotates{
                height: 190px;
                white-space: nowrap;
            }
            
            th.rotates > div{
                transform: translate(25px, 51px)rotate(-90deg);
                width:10px !important;
            }
            
            th.rotates > div > span{
/*                border: 1px solid #ccc;*/
            }
            body, html{
                background: white !important;
                font-size:10px !important;
            }
            .text-center{
                /*border:1px solid #333 !important;*/
            }
        </style>
</head>
<body>
<section id="main-content">
    <section class="wrapper">
    <!-- page start-->

    <div class="row">
        <div class="col-md-12">

    <div align="center" style="padding:30px;"><h2>OLABISI ONABANJO UNIVERSITY, AGOIWOYE, OGUN STATE.</h2>
        <h3>THE DEPARTMENT OF <?php echo Phalcon\Text::upper($this->request->getPost('department')); ?></h3>
        <strong>BROADSHEET FOR <?php echo $this->request->getPost('semester')==1?'HARMATTAN':'RAIN'; ?> <?php echo $this->request->getPost('session'); ?>[<?php echo $this->request->getPost('level'); ?>]</strong>
    </div>
    <style type="text/css">
        @media print{
            table td{
                padding: 2px !important;
            }
        }
        table td{
            padding: 2px !important;
        }
    </style>
    <table class="table .tablex" cellpadding="0" cellspacing="0"  style="border-top:1px solid #aaa; padding-top:40px; table-collapse:collapse;">
  <!--<thead>
    <tr>
      <th>#</th>
      <th class="rotates small"><div>COURSE TITLE</div></th>
      <th></th>
     <?php foreach ($regCourses as $keys => $values) { ?>
      <th class="rotates small text-center"><div><?php echo ucwords($values['title']); ?></div></th>
      <?php } ?>
      <th colspan="15"></th>
      
    </tr>
  </thead>-->
  <tbody>
    <tr>
      <td></td>
      <td></td>
      <td><strong>Course Code</strong></td>
      <td></td>
      <?php foreach ($regCourses as $keys => $values) { ?>
      <td class="text-center small" style="border:1px solid #aaa;"><?php echo Phalcon\Text::upper($values['code']); ?></td>
     <?php } ?>
      <td colspan="5" class="text-center small" align="center" style="border:1px solid #aaa;font-weight:bold;">CURRENT</td>
      <td colspan="5" class="small" align="center" style="border:1px solid #aaa;font-weight:bold;">PREVIOUS</td>
      <td colspan="5" class="text-center small" align="center" style="border:1px solid #aaa;font-weight:bold;">CUMULATIVE</td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td style="border:1px solid #aaa;"><strong>Course Units</strong></td>
      <td style="border:1px solid #aaa;"><strong>SEX</strong></td>
      <?php foreach ($regCourses as $keys => $values) { ?>
      <td class="text-center" style="border:1px solid #aaa;"><?php echo $values['units']; ?> [<?php echo $values['status']; ?>]</td>
      <?php } ?>
      <td class="text-center" style="border:1px solid #aaa;"><strong>TNU</strong></td>
      <td class="text-center" style="border:1px solid #aaa;"><strong>TNUP</strong></td>
      <td class="text-center" style="border:1px solid #aaa;"><strong>TNUF</strong></td>
      <td class="text-center" style="border:1px solid #aaa;"><strong>TCP</strong></td>
      <td class="text-center" style="border:1px solid #aaa;"><strong>GPA</strong></td>
      <!--<td class="text-center" style="border:1px solid #aaa;"><strong>REMARKS</strong></td>-->
      
      <td class="text-center" style="border:1px solid #aaa;"><strong>TNU</strong></td>
      <td class="text-center" style="border:1px solid #aaa;"><strong>TNUP</strong></td>
      <td class="text-center" style="border:1px solid #aaa;"><strong>TNUF</strong></td>
      <td class="text-center" style="border:1px solid #aaa;"><strong>TCP</strong></td>
      <td class="text-center" style="border:1px solid #aaa;"><strong>GPA</strong></td>
      <!--<td class="text-center" style="border:1px solid #aaa;"><strong>REMARKS</strong></td>-->
      
      <td class="text-center" style="border:1px solid #aaa;"><strong>TNU</strong></td>
      <td class="text-center" style="border:1px solid #aaa;"><strong>TNUP</strong></td>
      <td class="text-center" style="border:1px solid #aaa;"><strong>TNUF</strong></td>
      <td class="text-center" style="border:1px solid #aaa;"><strong>TCP</strong></td>
      <td class="text-center" style="border:1px solid #aaa;"><strong>GPA</strong></td>
      <td class="text-center" style="border:1px solid #aaa;"><strong>REMARKS</strong></td>
      
    </tr>
    <tr>
      <td><strong>S/No</strong></td>
      <td><strong>MATRIC NO</strong></td>
      <td><strong>NAME OF CANDIDATE</strong></td>
      <td></td>
      <?php foreach ($regCourses as $keys => $values) { ?>
      <td>&nbsp;</td>
      <?php } ?>
      <td colspan="5" class="text-center">&nbsp;</td>
      <td colspan="5" class="text-center">&nbsp;</td>
      <td colspan="5" class="text-center">&nbsp;</td>
    </tr>
    
    <?php foreach ($regStudents as $keys => $values) { ?>
    <tr>
      <td style="border:1px solid #aaa;"><?php echo $keys + 1; ?></td>
      <td style="border:1px solid #aaa;"><?php echo $values['matric']; ?></td>
      <td style="border:1px solid #aaa;"><?php echo ucwords($values['fullname']); ?></td>
      <td style="border:1px solid #aaa;"><?php echo ucwords($values['sex']); ?></td>
      <?php foreach ($regCourses as $rKeys => $rValues) { ?>
      <?php $arraySet = array('matric' => $values['matric'], 'course' => $rValues['code']); ?>
      <td class="text-center" align="center" style="border:1px solid #aaa;"><?php $results = GradePoints::__getResults($arraySet); ?>
      <?php if (isset($results[0]['ca'])) { ?>
      <?php echo $results[0]['ca'] + $results[0]['exam']; ?><br/><?php echo @$gradePointer->__strVar(@$results[0]['ca']+@$results[0]['exam']); ?>
      <?php $gradePointer->__gradeParser(@$results[0]['ca']+@$results[0]['exam'], @$rValues['units'],@$rValues['code']); ?>
      <?php } else { ?>
      <?php $gradePointer->__gradeParser(@$results[0]['ca']+@$results[0]['exam'], @$rValues['units'],@$rValues['code']); ?>
      0<br/><?php echo @$gradePointer->__strVar(@$results[0]['ca']+@$results[0]['exam']); ?>
      <?php } ?>
      </td>
      <!--<td class="text-center" style="border:1px solid #aaa;"><?php $gradePointer->__gradeParser(@$results[0]['ca']+@$results[0]['exam'], @$rValues['units'],@$rValues['code']); ?></td>-->
      <?php @$gradePointer->__setUnits($rValues['units']); ?>
      <?php } ?>
      <td class="text-center" style="border:1px solid #aaa;"><?php echo @$gradePointer->__getTotalUnits(); ?></td>
      <td class="text-center" style="border:1px solid #aaa;"><?php echo @$gradePointer->__getTotalUnitPass(); ?></td>
      <td class="text-center" style="border:1px solid #aaa;"><?php echo @$gradePointer->__getTotalUnitFail(); ?></td>
      <td class="text-center" style="border:1px solid #aaa;"><?php echo @$gradePointer->__getTotalGrade(); ?></td>
      <td class="text-center" style="border:1px solid #aaa;"><?php echo @$gradePointer->__weightedGradeAvr(); ?></td>
      <!--<td class="text-center" style="border:1px solid #aaa;"><?php echo @strtoupper($gradePointer->__getRemarks()); ?></td>-->

      <?php @$gradePointer->__clearSetArray(); ?>
        <?php $typeArray = array('matric'=>$values['matric'],'department'=>$this->session->get('hod')['hoddept'],'semester'=>$values['semester'],'level'=>$values['level']); ?>
      <?php $remark = @$collective->__getOtherSemester($typeArray); ?>
      
      <td class="text-center" style="border:1px solid #aaa;"><?php if($this->request->getPost('level') && ($this->request->getPost('semester')!=1)){ echo @GradePoints::__getTotalUnits();} ?></td>
      <td class="text-center" style="border:1px solid #aaa;"><?php if($this->request->getPost('level') && ($this->request->getPost('semester')!=1)){ echo @GradePoints::__getTotalUnitPass();} ?></td>
      <td class="text-center" style="border:1px solid #aaa;"><?php if($this->request->getPost('level') && ($this->request->getPost('semester')!=1)){echo @GradePoints::__getTotalUnitFail();} ?></td>
      <td class="text-center" style="border:1px solid #aaa;"><?php if($this->request->getPost('level') && ($this->request->getPost('semester')!=1)){echo @GradePoints::__getTotalGrade();} ?></td>
      <td class="text-center" style="border:1px solid #aaa;"><?php if($this->request->getPost('level') && ($this->request->getPost('semester')!=1)){echo @GradePoints::__weightedGradeAvr();} ?></td>
      <!--<td class="text-center" style="border:1px solid #aaa;"><?php echo @strtoupper($remark); ?></td>-->

     <?php $gradePointer->__clearSetArray(); ?>
      
     <?php $typeArray = array('matric'=>$values['matric'],'department'=>$this->session->get('hod')['hoddept']); ?>
      <?php $remark = @$collective->__getAllSemester($typeArray); ?>
      
      <td class="text-center" style="border:1px solid #aaa;"><?php echo @GradePoints::__getTotalUnits(); ?></td>
      <td class="text-center" style="border:1px solid #aaa;"><?php echo @GradePoints::__getTotalUnitPass(); ?></td>
      <td class="text-center" style="border:1px solid #aaa;"><?php echo @GradePoints::__getTotalUnitFail(); ?></td>
      <td class="text-center" style="border:1px solid #aaa;"><?php echo @GradePoints::__getTotalGrade(); ?></td>
      <td class="text-center" style="border:1px solid #aaa;"><?php echo @GradePoints::__weightedGradeAvr(); ?></td>
      <td class="text-center" style="border:1px solid #aaa;"><?php echo !empty($remark) ? @strtoupper($remark) : 'PASSED'; ?></td>
     <?php $gradePointer->__clearSetArray(); ?>
    </tr>
     
    <?php } ?>
  </tbody>
</table>

        </div>
    </div>
<button class="btn btn-primary noprint" onclick="window.print();">Print Page</button>
</section>
</section>
<script type="text/javascript">
    window.print();
    
</script>
</body>
</html>