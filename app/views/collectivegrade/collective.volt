{% extends "templates/print.volt" %}
{% block content %}
    <div align="center" style="padding:30px;"><h2>OLABISI ONABANJO UNIVERSITY, AGOIWOYE, OGUN STATE.</h2>
        <h3>THE DEPARTMENT OF {{this.request.getPost('department') | upper}}</h3>
        <strong>BROADSHEET FOR <?php echo $this->request->getPost('semester')==1?'HARMATTAN':'RAIN'; ?> {{this.request.getPost('session')}}[{{this.request.getPost('level')}}]</strong>
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
     {% for keys, values in regCourses %}
      <th class="rotates small text-center"><div>{{values['title'] | capitalize}}</div></th>
      {% endfor %}
      <th colspan="15"></th>
      
    </tr>
  </thead>-->
  <tbody>
    <tr>
      <td></td>
      <td></td>
      <td><strong>Course Code</strong></td>
      <td></td>
      {% for keys, values in regCourses %}
      <td class="text-center small" style="border:1px solid #aaa;">{{values['code'] | upper}}</td>
     {% endfor %}
      <td colspan="5" class="text-center small" align="center" style="border:1px solid #aaa;font-weight:bold;">CURRENT</td>
      <td colspan="5" class="small" align="center" style="border:1px solid #aaa;font-weight:bold;">PREVIOUS</td>
      <td colspan="5" class="text-center small" align="center" style="border:1px solid #aaa;font-weight:bold;">CUMULATIVE</td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td style="border:1px solid #aaa;"><strong>Course Units</strong></td>
      <td style="border:1px solid #aaa;"><strong>SEX</strong></td>
      {% for keys, values in regCourses %}
      <td class="text-center" style="border:1px solid #aaa;">{{values['units']}} [{{values['status']}}]</td>
      {% endfor %}
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
      {% for keys, values in regCourses %}
      <td>&nbsp;</td>
      {% endfor %}
      <td colspan="5" class="text-center">&nbsp;</td>
      <td colspan="5" class="text-center">&nbsp;</td>
      <td colspan="5" class="text-center">&nbsp;</td>
    </tr>
    
    {% for keys,values in regStudents %}
    <tr>
      <td style="border:1px solid #aaa;">{{keys+1}}</td>
      <td style="border:1px solid #aaa;"><?php echo $values['matric']; ?></td>
      <td style="border:1px solid #aaa;"><?php echo ucwords($values['fullname']); ?></td>
      <td style="border:1px solid #aaa;"><?php echo ucwords($values['sex']); ?></td>
      {% for rKeys, rValues in regCourses %}
      {% set arraySet = ['matric':values['matric'],'course':rValues['code']] %}
      <td class="text-center" align="center" style="border:1px solid #aaa;">{% set results = getResults(arraySet) %}
      {% if results[0]['ca'] is defined %}
      {{results[0]['ca']+results[0]['exam']}}<br/><?php echo @$gradePointer->__strVar(@$results[0]['ca']+@$results[0]['exam']); ?>
      <?php $gradePointer->__gradeParser(@$results[0]['ca']+@$results[0]['exam'], @$rValues['units'],@$rValues['code']); ?>
      {% else %}
      <?php $gradePointer->__gradeParser(@$results[0]['ca']+@$results[0]['exam'], @$rValues['units'],@$rValues['code']); ?>
      0<br/><?php echo @$gradePointer->__strVar(@$results[0]['ca']+@$results[0]['exam']); ?>
      {% endif %}
      </td>
      <!--<td class="text-center" style="border:1px solid #aaa;"><?php $gradePointer->__gradeParser(@$results[0]['ca']+@$results[0]['exam'], @$rValues['units'],@$rValues['code']); ?></td>-->
      <?php @$gradePointer->__setUnits($rValues['units']); ?>
      {% endfor %}
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
     
    {% endfor %}
  </tbody>
</table>
{% endblock %}