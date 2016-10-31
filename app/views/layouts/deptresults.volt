{% extends "templates/base.volt" %}

{% block head %}
{% endblock %}
{% block content %}
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Department Result | <strong>View results</strong>
            </header>
            <div class="panel-body">
                <div class="position-left">
                    <form class="form-inline" method="post" target="_blank" action="{{url('collectivegrade/collective')}}" role="form">
                    <div class="form-group">
                        <input type="hidden" value="{{this.session.get('hod')['hoddept']}}" name="department" />
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
                                {{selectSession}}
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