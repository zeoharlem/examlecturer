
{% block head %}
{% endblock %}
{% block content %}
{% if packs is defined %}
    <div class="col-sm-12">
                    <section class="panel">
                        <header class="panel-heading">
                            <strong>{{packs[0]['title']}} / Session ({{packs[0]['session']}})</strong>
                            <span class="tools pull-right">
                                <form id="fileupload" action="{{url('results/uploadAjax')}}" method="post" enctype="multipart/form-data">
                                        <div class="fileupload-buttonbar pull-left">
                                            
                                                <!-- The fileinput-button span is used to style the file input field as button -->
                                                <span class="btn btn-success fileinput-button btn-sm">
                                                <i class="glyphicon glyphicon-plus"></i>
                                                <span class="addFile"><strong style="text-transform:capitalize">Add | Browse Excel File</strong></span>
                                                <input type="file" name="files" id="files">
                                                </span>
                                            
                                            <!-- The global progress state -->
                                        </div>
                                    </form>&nbsp;
                             </span>
                        </header>
                        <div class="panel-body">
                        <form method="post" role="form" class="form-horizontal" action="{{url('results/postResult')}}">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th style="border:1px solid #ddd;">Students</th>
                                    <th style="border:1px solid #ddd;">Description</th>
                                    <th style="border:1px solid #ddd;">Course Code</th>
                                    
                                    <th style="border:1px solid #ddd;">Session</th>
                                    <th style="border:1px solid #ddd;">Department(s)</th>
                                    <th style="border:1px solid #ddd;">Action(s)</th>
                                </tr>
                                </thead>
                                <tbody>
                                {% for keys,values in packs%}
                                <tr>
                                    <td style="border:1px solid #ddd;">{{keys+1}}<input type="hidden" name="matric[]" value="{{values['matric']}}" /></td>
                                    <td style="border:1px solid #ddd;">{{values['fullname'] | capitalize}}</td>
                                    <td style="border:1px solid #ddd;">{{values['title'] | capitalize}}</td>
                                    <td style="border:1px solid #ddd;">{{values['code'] | uppercase}}<input type="hidden" name="course[]" value="{{values['code']}}" /></td>
                                    
                                    <td style="border:1px solid #ddd;">{{values['session']}}<input type="hidden" name="creg_id[]" value="{{values['creg_id']}}" /></td>
                                    <td style="border:1px solid #ddd;">{{values['department'] | capitalize}}</td>
                                    <td style="border:1px solid #ddd;">
                                    
                                    <input type="text" maxlength=2 required name="ca[]" value="{{values['ca']}}" class="form-control pull-left" size=2 style="width:50px; margin-right:5px;" placeholder="CA" /> <input type="text" maxlength=2 name="exam[]" required value="{{values['exam']}}" class="form-control pull-left" placeholder="Exam" size=2 style="width:50px;" /></td>
                                    
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
                                    <button type="submit" class="btn btn-primary btn-sm"><strong>Upload</strong></button> <button type="reset" class="btn btn-danger btn-sm"><strong>Reset</strong></button></td>
                                </tr>
                                </tbody>
                            </table>
                            </form>
                        </div>
                    </section>
                </div>

{% else %}
<div class="alert alert-warning"><strong>No Student Has Registered Yet</strong></div>
{% endif %}

{% endblock %}