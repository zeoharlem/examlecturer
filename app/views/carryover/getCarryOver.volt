{% block content %}
    <div class="col-sm-12">
                    {% if carryover is defined %}
                    <section class="panel">
                        <header class="panel-heading">
                            <strong>Students Carry Over</strong>
                            <span class="tools pull-right">
                                <a href="javascript:;" class="fa fa-chevron-down"></a>
                                <a href="javascript:;" class="fa fa-cog"></a>
                                <a href="javascript:;" class="fa fa-times"></a>
                             </span>
                        </header>
                        <div class="panel-body">
                        <form method="post" action="{{url('carryover/postover')}}">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th style="border:1px solid #ddd;">Matric Number</th>
                                    <th style="border:1px solid #ddd;">Code</th>
                                    <th style="border:1px solid #ddd;">Course Description</th>
                                    <th style="border:1px solid #ddd;">Level</th>
                                    <th style="border:1px solid #ddd;">Semester</th>
                                    <th style="border:1px solid #ddd;">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                {% for keys,values in carryover %}
                                <tr>
                                    <td>{{keys+1}}</td>
                                    <td style="border:1px solid #ddd;">{{values.matric}}</td>
                                    <td style="border:1px solid #ddd;">{{values.code | upper}}</td>
                                    <td style="border:1px solid #ddd;">{{values.title | capitalize}}</td>
                                    <td style="border:1px solid #ddd;">{{values.level}}</td>
                                    <td style="border:1px solid #ddd;">{{values.semester}}</td>
                                    <td style="border:1px solid #ddd;"><div class="col-lg-2">
                                        <input type="hidden" name="matric[]" value="{{values.matric}}" />
                                        <input type="hidden" name="course[]" value="{{values.code}}" />
                                        <input type="hidden" name="creg_id[]" value="{{values.creg_id}}" />
                                        <input type="text" class="form-control" maxlength="2" name="ca[]" /></div>
                                        <div class="col-lg-2">
                                        <input type="text" class="form-control" maxlength="2" name="exam[]" /></div>
                                    </td>
                                </tr>
                                {% endfor %}
                                <tr style="border:1px solid #ddd;">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                    <button class="btn btn-primary"><strong>Upload</strong></button>
                                    <button class="btn btn-success"><strong>Reset</strong></button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </form>    
                        </div>
                    </section>
                
                {% else %}
                    <div class="alert alert-danger"><strong>No Carry Over Registration</strong></div>
                 {% endif %}
    </div>
{% endblock %}