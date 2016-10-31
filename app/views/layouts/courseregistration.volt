{% extends "templates/base.volt" %}

{% block head %}
{% endblock %}
{% block content %}
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Download | <strong>Registered Sheet</strong>
            </header>
            <div class="panel-body">
                <div class="position-left">
                    <form class="form-inline" method="post" action="{{url('courseregistration/download')}}" role="form">
                    <div class="form-group">
                        
                        <select class="form-control input-lg" name="code" style="color:#888;">
                            {% for keys, values in depts %}
                            <option value="{{values.code}}">{{values.title | capitalize}}</option>
                            {% endfor %}
                        </select>
                    </div>
                    <!--<div class="form-group">
                        
                        <select class="form-control input-lg" name="level" style="color:#888;">
                                <option value="">Level</option>
                                <option value="100">100 Level</option>
                                <option value="200">200 Level</option>
                                <option value="300">300 Level</option>
                                <option value="400">400 Level</option>
                            </select>
                    </div>-->

                    <div class="form-group">
                        
                        <select class="form-control input-lg" name="semester" style="color:#888;">
                                <option value="">Select</option>
                                <option value="1">Harmattan</option>
                                <option value="2">Rain</option>
                            </select>
                    </div>

                    <div class="form-group">
                        
                        <select class="form-control input-lg" name="session" style="color:#888;">
                                <option value="">Session</option>
                                <option value="2015/2016">2015/2016</option>
                            </select>
                    </div>
                    
                    <button type="submit" class="btn btn-success btn-lg"><strong>Load</strong></button>
                    <button type="reset" class="btn btn-default btn-lg"><strong>Reset</strong></button>
                </form>
                </div>
            </div>
        </section>

    </div>
    {{this.getContent()}}
{% endblock %} 