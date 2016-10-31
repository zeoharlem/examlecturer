{% extends "templates/base.volt" %}

{% block head %}
{% endblock %}
{% block content %}
    <div class="col-lg-11">
        <section class="panel">
            <header class="panel-heading">
                Form Elements | <strong>Create Course</strong>
            </header>
            <div class="panel-body">
                <form class="form-horizontal bucket-form" method="post">
                                        <div class="form-group">
                        <label class="col-sm-3 control-label">Semester</label>
                        <div class="col-sm-6">
                            <select class="form-control" name="semester">
                                <option value="1">Summer</option>  
                                <option value="2">Raining</option>  
                            </select>
                            <p class="help-block"><strong>Example block-level help text here.</strong></p>
                        </div>
                    </div>
                                        <div class="form-group">
                        <label class="col-sm-3 control-label">Session</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="session" placeholder="Enter the session course was offered"/>
                        </div>
                    </div>
                                        <div class="form-group">
                        <label class="col-sm-3 control-label">Level</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="level" placeholder="Type the level offering the course"/>
                        </div>
                    </div>
                                        <div class="form-group">
                        <label class="col-sm-3 control-label">Code</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="code" placeholder="Type the course code"/>
                        </div>
                    </div>
                                        <div class="form-group">
                        <label class="col-sm-3 control-label">Units</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="units" placeholder="Unit of the course created"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Title</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control input-lg" name="title" placeholder="Enter the course description "/>
                        </div>
                    </div>
                                     <div class="form-group">
                        <label class="col-sm-3 control-label col-lg-3" for="inputSuccess">Department</label>
                        <div class="col-lg-6">
                            <select class="form-control m-bot15 input-lg" name="department">
                                {% for keys, values in departments %}
                                <option value="{{values.description}}">{{values.description}}</option>  
                                {% endfor %}
                            </select>
                            <input type="hidden" name="codename" value="{{codename}}" />
                        </div>
                    </div>
                        <div class="form-group">
                        <label class="col-sm-3 control-label col-lg-3" for="inputSuccess">Status</label>
                        <div class="col-lg-6">
                            <select class="form-control" name="status">
                                <option value="C">Compulsory</option>  
                                <option value="E">Elective</option>  
                            </select>
                        <p class="help-block"><strong>Select whether compulsory or elective.</strong></p>    
                        </div>
                    </div>
                    <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-10">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"> Are you sure?
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-10">
                                    <button type="submit" class="btn btn-danger" name="postCourse">Start Now</button>
                                    <button type="reset" class="btn btn-primary">Reset Now</button>
                                </div>
                            </div>
                </form>
            </div>
        </section>
        </div>
{% endblock %}