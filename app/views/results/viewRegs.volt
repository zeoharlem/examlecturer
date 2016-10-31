
{% block content %}
    <div class="col-sm-12">
                    <section class="panel">
                        <header class="panel-heading">
                            <strong>Result Upload</strong>
                            <span class="tools pull-right">
                                <a href="javascript:;" class="fa fa-chevron-down"></a>
                                <a href="javascript:;" class="fa fa-cog"></a>
                                <a href="javascript:;" class="fa fa-times"></a>
                             </span>
                        </header>
                        <div class="panel-body">
                        {% if listView is defined %}
                        <form method="post" role="form" action="{{url('results/post')}}">
                        
                            <p>&nbsp;</p>
                            
                            <table class="table table-hover table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th style="border:1px solid #ccc;">Student Name(s)</th>
                                    <th style="border:1px solid #ccc;">Matric Numbers</th>
                                    <th style="border:1px solid #ccc;">Departments</th>
                                    <th style="border:1px solid #ccc;">Title</th>
                                    <th style="border:1px solid #ccc;">Code</th>
                                    <th style="border:1px solid #ccc;">CA</th>
                                    <th style="border:1px solid #ccc;">Exam Score</th>
                                </tr>
                                </thead>
                                <tbody>
                                {% for keys,values in listView %}
                                <tr>
                                    <td style="border:1px solid #ccc;"><strong>{{keys+1}}</strong></td>
                                    <td>{{values['fullname']}}<input type="hidden" name="creg_id[]" value="{{values['creg_id']}}" /></td>
                                    <td>{{values['matric']}}<input type="hidden" name="matric[]" value="{{values['matric']}}" /></td>
                                    <td>{{values['department']}}<input type="hidden" name="course[]" value="{{values['course']}}" /></td>
                                    <td>{{values['title'] | capitalize}}</td>
                                    <td>{{values['course'] | uppercase}}</td>
                                    <td><input type="text" name="ca[]" value="{{values['ca']}}" style="width:80px; font-size:13px;" maxlength="2" placeholder="CA" class="form-control" /></td>
                                    <td><input type="text" name="exam[]" value="{{values['exam']}}" style="width:80px; font-size:13px;" maxlength="2" placeholder="Exam" class="form-control" /></td>
                                </tr>
                                {% endfor %}
                                <tr>
                                    <td></td>
                                    <td>
                                    <button type="submit" class="btn btn-danger"><strong>Submit</strong></button>
                                    <button type="reset" class="btn btn-primary"><strong>Reset</strong></button>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                </tbody>
                            </table>
                            </form>
                            {% else %}
                            <div class="alert alert-danger col-lg-7">No Registration for this course found</div>
                            {% endif %}
                        </div>
                    </section>
                </div>
{% endblock %}