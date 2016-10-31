{% extends "templates/base.volt" %}

{% block head %}
{% endblock %}
{% block content %}
    <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Create Lecturers
                    </header>
                    <div class="panel-body">
                        <div class="position-center">
                            <form class="form-horizontal" method="post" action="{{url('lecturer/create')}}" role="form">
                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Email</label>
                                <div class="col-lg-10">
                                    <input type="text" name="email" class="form-control" id="inputEmail1" placeholder="Email">
                                    <p class="help-block"><strong>Example block-level help text here.</strong></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">First Name</label>
                                <div class="col-lg-10">
                                    <input type="text" name="firstname" class="form-control input-lg" id="inputEmail1" placeholder="Enter Lecturer's first name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Last Name</label>
                                <div class="col-lg-10">
                                    <input type="text" name="lastname" class="form-control input-lg" id="inputEmail1" placeholder="Enter Lecturer's Last name">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-offset-2 col-lg-10">
                                    <button type="submit" class="btn btn-primary btn-lg"><strong>Create</strong></button>
                                    <button type="reset" class="btn btn-danger btn-lg"><strong>Reset</strong></button>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                </section>

            </div>
{% endblock %}