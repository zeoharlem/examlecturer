{% extends "templates/print.volt" %}

{% block content %}
    <div class="col-sm-12">
        <section class="panel">
            <header class="panel-heading">
                Result of Students
                <span class="tools pull-right">
                    <a href="javascript:;" class="fa fa-chevron-down"></a>
                    <a href="javascript:;" class="fa fa-cog"></a>
                    <a href="javascript:;" class="fa fa-times"></a>
                 </span>
            </header>
            <div class="panel-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Students Name</th>
                        <th>Matric Number</th>
                        <th>Course</th>
                        <th>Department</th>
                        <th>CA</th>
                        <th>Exam</th>
                        <th>Total Score</th>
                    </tr>
                    </thead>
                    <tbody>
                    {% for keys,values in flowStack %}
                    <tr>
                        <td>{{keys + 1}}</td>
                        <td>{{values['full'] | capitalize}}</td>
                        <td>{{values['matric']}}</td>
                        <td>{{values['course'] | upper}}</td>
                        <td>{{values['department'] | capitalize}}</td>
                        <td>{{values['ca']}}</td>
                        <td>{{values['exam']}}</td>
                        <td>{{values['totalScore']}}</td>
                    </tr>
                    {% endfor %}
                    </tbody>
                </table>
            </div>

        </section>
    </div>
{% endblock %}