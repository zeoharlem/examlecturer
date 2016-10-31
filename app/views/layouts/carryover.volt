{% extends "templates/base.volt" %}

{% block head %}
{% endblock %}
{% block content %}
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <strong>Load Carry Overs</strong>
            </header>
            <div class="panel-body">
                <div class="position-left">
                    <form class="form-inline" method="post" action="{{url('carryover/getCarryOver')}}" role="form">
                    <div class="form-group">
                        <select class="form-control input-lg" name="code" style="font-size:13px;">
                            {% for keys,values in courses %}
                                <option value="{{values.code}}" style="font-size:13px;">{{values.title | capitalize}}</option>
                            {% endfor %}
                        </select>
                        <input type="hidden" name="lecturer" value="{{session.get('auth')['codename']}}" />
                    </div>
                    <div class="form-group">
                        
                        <select class="form-control input-lg" name="level">
                                <option value="100">100 Level</option>
                                <option value="200">200 Level</option>
                                <option value="300">300 Level</option>
                                <option value="400">400 Level</option>
                        </select>
                    </div>
                    <div class="form-group">
                        
                        <select class="form-control input-lg" name="semester">
                                <option value="1">Harmattan</option>
                                <option value="2">Rain</option>
                        </select>
                    </div>
                    <div class="form-group">
                        
                        <select class="form-control input-lg" name="session">
                                <option value="2015/2016">2015/2016</option>
                            </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-lg"><strong>Load</strong></button>
                    <button type="reset" class="btn btn-success btn-lg"><strong>Reset</strong></button>
                </form>
                </div>
            </div>
        </section>

    </div>
    {{this.getContent()}}
{% endblock %} 