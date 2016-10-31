{% extends "templates/print.volt" %}
{% block content %}
    <table class="table" >
  <thead>
    <tr>
      <th>#</th>
      <th class="rotates small"><div>COURSE TITLE</div></th>
     {% for keys, values in regCourses %}
      <th colspan="2" class="rotates small text-center"><div>{{values['title'] | capitalize}}</div></th>
      {% endfor %}
      <th colspan="15"></th>
      
    </tr>
  </thead>
  <tbody>
    <tr>
      <td></td>
      <td><strong>Course Code</strong></td>
      {% for keys, values in regCourses %}
      <td colspan="2" class="text-center small">{{values['code'] | upper}}</td>
     {% endfor %}
      <td colspan="5" class="text-center small">CURRENT SEMESTER</td>
      <td colspan="5" class="text-center small">OTHER SEMESTER</td>
      <td colspan="5" class="text-center small">ALL SEMESTER</td>
    </tr>
    <tr>
      <td></td>
      <td><strong>Course Units</strong></td>
      {% for keys, values in regCourses %}
      <td colspan="2" class="text-center">{{values['units']}}</td>
      {% endfor %}
      <td class="text-center"><strong>UT</strong></td>
      <td class="text-center"><strong>UP</strong></td>
      <td class="text-center"><strong>UF</strong></td>
      <td class="text-center"><strong>TGP</strong></td>
      <td class="text-center"><strong>WGP</strong></td>
      <td class="text-center"><strong>UT</strong></td>
      <td class="text-center"><strong>UP</strong></td>
      <td class="text-center"><strong>UF</strong></td>
      <td class="text-center"><strong>TGP</strong></td>
      <td class="text-center"><strong>WGP</strong></td>
      <td class="text-center"><strong>UT</strong></td>
      <td class="text-center"><strong>UP</strong></td>
      <td class="text-center"><strong>UF</strong></td>
      <td class="text-center"><strong>TGP</strong></td>
      <td class="text-center"><strong>WGP</strong></td>
    </tr>
    <tr>
      <td><strong>MATRIC NOS</strong></td>
      <td><strong>NAME OF STUDENTS</strong></td>
      {% for keys, values in regCourses %}
      <td colspan="2" >&nbsp;</td>
      {% endfor %}
      <td colspan="5" class="text-center">&nbsp;</td>
      <td colspan="5" class="text-center">&nbsp;</td>
      <td colspan="5" class="text-center">&nbsp;</td>
    </tr>
    
    {% for keys,values in regStudents %}
    <tr>
      <td><?php echo $values['matric']; ?></td>
      <td><?php echo ucwords($values['fullname']); ?></td>
      {% for rKeys, rValues in regCourses %}
      {% set arraySet = ['matric':values['matric'],'course':rValues['code']] %}
      <td class="text-center">{% set results = getResults(arraySet) %}{{results[0]['exam']}}</td>
      <td class="text-center"><?php echo $gradePointer->__gradeParser($results[0]['exam'], $rValues['units']); ?></td>
      <?php $gradePointer->__setUnits($rValues['units']); ?>
      {% endfor %}
      <td class="text-center"><?php echo $gradePointer->__getTotalUnits(); ?></td>
      <td class="text-center"><?php echo $gradePointer->__getTotalUnitPass(); ?></td>
      <td class="text-center"><?php echo $gradePointer->__getTotalUnitFail(); ?></td>
      <td class="text-center"><?php echo $gradePointer->__getTotalGrade(); ?></td>
      <td class="text-center"><?php echo $gradePointer->__weightedGradeAvr(); ?></td>
      
      <?php $gradePointer->__clearSetArray(); ?>
        <?php $typeArray = array('matric'=>$values['matric'],'level'=>$values['level']); ?>
      <?php $collective->__getOtherSemester($typeArray); ?>
      
      <td class="text-center"><?php echo GradePoints::__getTotalUnits(); ?></td>
      <td class="text-center"><?php echo GradePoints::__getTotalUnitPass(); ?></td>
      <td class="text-center"><?php echo GradePoints::__getTotalUnitFail(); ?></td>
      <td class="text-center"><?php echo GradePoints::__getTotalGrade(); ?></td>
      <td class="text-center"><?php echo GradePoints::__weightedGradeAvr(); ?></td>
     <?php $gradePointer->__clearSetArray(); ?>
      
     <?php $typeArray = array('matric'=>$values['matric']); ?>
      <?php $collective->__getAllSemester($typeArray); ?>
      
      <td class="text-center"><?php echo GradePoints::__getTotalUnits(); ?></td>
      <td class="text-center"><?php echo GradePoints::__getTotalUnitPass(); ?></td>
      <td class="text-center"><?php echo GradePoints::__getTotalUnitFail(); ?></td>
      <td class="text-center"><?php echo GradePoints::__getTotalGrade(); ?></td>
      <td class="text-center"><?php echo GradePoints::__weightedGradeAvr(); ?></td>
     <?php $gradePointer->__clearSetArray(); ?>
    </tr>
     
    {% endfor %}
  </tbody>
</table>
{% endblock %}