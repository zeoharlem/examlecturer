{% block content %}
    {% if courseList is defined %}
    <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    <strong>Create Session Package</strong>
                    <select name="semester" id="semester">
                        <option value="1">1</option>
                        <option value="2">2</option>
                    </select>
                    <select name="session" id="session">
                        <option value="2014/2015">2014/2015</option>
                        <option value="2015/2016">2015/2016</option>
                    </select>
                    <span class="tools pull-right">
                        <a href="javascript:;" class="fa fa-chevron-down"></a>
                        <a href="javascript:;" class="fa fa-cog"></a>
                        <a href="javascript:;" class="fa fa-times"></a>
                     </span>
                </header>
                <div class="panel-body">
                <form id="packageform" role="form">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th><input type="checkbox" /></th>
                            <th>Courses Description</th>
                            <th>Course Code</th>
                            <th>Units</th>
                            <th>Status</th>
                            <th>Department</th>
                            <th>Semester</th>
                        </tr>
                        </thead>
                        <tbody>
                        {% for keys, values in courseList %}
                        <tr>
                            <td><input type="checkbox" name="checkboxId[]" value={{values.c_id}} class="checkboxFlow" /></td>
                            <td>{{values.title | uppercase}}</td>
                            <td>{{values.code | uppercase}}</td>
                            <td>{{values.units}}</td>
                            <td>{{values.status}}</td>
                            <td>{{values.department | capitalize}}</td>
                            <td>{{values.semester}}</td>
                        </tr>
                        {% endfor %}
                        </tbody>
                    </table>
                    <button type="button" id="startPackage" class="btn btn-lg btn-default"><strong>Start Package</strong></button>
                    </form>
                </div>
            </section>
        </div>
    {% endif %}
{% endblock %}