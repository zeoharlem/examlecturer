{% extends "templates/base.volt" %}

{% block head %}
{% endblock %}
{% block content %}
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <strong>Display Students</strong>
            </header>
            <div class="panel-body">
                <div class="position-left">
                    <form class="form-inline" method="post" action="{{url('results/getOffers')}}" role="form">
                    <div class="form-group">
                        
                        <select class="form-control" name="code">
                            {% for keys, values in depts %}
                            <option value="{{values.code}}">{{values.title | capitalize}}</option>
                            {% endfor %}
                        </select>
                    </div>
                    <div class="form-group">
                        
                        <select class="form-control" name="level">
                                <option value="">Level</option>
                                <option value="100">100 Level</option>
                                <option value="200">200 Level</option>
                                <option value="300">300 Level</option>
                                <option value="400">400 Level</option>
                            </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="semester">
                                <option value=""> Semester </option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                            </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="session">
                                <option value="">Session</option>
                                <option value="2014/2015">2014/2015</option>
                                <option value="2015/2016">2015/2016</option>
                            </select>
                    </div>
                    <input type="hidden" name="lecturer" value="{{session.get('auth')['codename']}}" />
                    <button type="submit" class="btn btn-primary"><strong>Display</strong></button>
                    <button type="reset" class="btn btn-default"><strong>Reset</strong></button>
                </form>
                </div>
            </div>
        </section>

    </div>
    {% if comArray is defined %}
        <div class="col-sm-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Registered Student List
                            <span class="tools pull-right">
                                <a href="javascript:;" class="fa fa-chevron-down"></a>
                                <a href="javascript:;" class="fa fa-cog"></a>
                                <a href="javascript:;" class="fa fa-times"></a>
                             </span>
                        </header>
                        <div class="panel-body">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th style="border:1px solid #ddd;">Student(s) Name</th>
                                    <th style="border:1px solid #ddd;">Matric</th>
                                    <th style="border:1px solid #ddd;">Department</th>
                                    <th style="border:1px solid #ddd;">Email</th>
                                    <th style="border:1px solid #ddd;">Session</th>
                                    
                                    <th style="border:1px solid #ddd;">Action(s)</th>
                                </tr>
                                </thead>
                                <tbody>
                                {% for keys,values in comArray %}
                                <tr>
                                    <td style="border:1px solid #ddd;">{{keys+1}}</td>
                                    <td>{{values['fullname'] | capitalize}}</td>
                                    <td>{{values['matric']}}</td>
                                    <td>{{values['department'] | uppercase}}</td>
                                    <td>{{values['email']}}<br/><small><i class="fa fa-phone"></i> <strong>{{values['phone']}}</strong></small></td>
                                    <td>{{values['session']}}</td>
                                    
                                    <td style="border:1px solid #ddd;">
                                        <div class="btn-row">
                                            <div class="btn-group">
                                                <a href="{{url('results/view?level=100&matric='~values['matric']~'&session='~values['session'])}}" class="btn btn-white" style=" font-size:13px;">1</a>
                                                <a href="{{url('results/view?level=200&matric='~values['matric']~'&session='~values['session'])}}" class="btn btn-white" style="font-size:13px;">2</a>
                                                <a href="{{url('results/view?level=300&matric='~values['matric']~'&session='~values['session'])}}" class="btn btn-white" style="font-size:13px;">3</a>
                                                <a href="{{url('results/view?level=400&matric='~values['matric']~'&session='~values['session'])}}" class="btn btn-white" style="font-size:13px;">4</a>
                                                
                                            </div>
                                        </div>    
                                    </td>
                                </tr>
                                {% endfor %}
                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
    {% endif %}
{% endblock %} 