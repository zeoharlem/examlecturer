{% extends "templates/base.volt" %}

{% block head %}
{% endblock %}
{% block content %}
    <div class="col-md-4" class="addToCart">
    <!--pagination start-->
    <section class="panel">
        <header class="panel-heading">
            <strong><i class="fa fa-edit"></i> &nbsp; <a href="{{url('students/')}}" style="text-transform: capitalize">View Students</a></strong>
        <span class="tools pull-right">
            <a href="javascript:;" class="fa fa-chevron-up"></a>
            <a href="javascript:;" class="fa fa-times"></a>
        </span>
        </header>
    </section>
    <!--pagination end-->
    </div>

    <div class="col-md-4" class="addToCart">
    <!--pagination start-->
    <section class="panel">
        <header class="panel-heading">
            <strong><i class="fa fa-hdd-o"></i> &nbsp; <a href="{{url('results/')}}" style="text-transform: capitalize">Upload Results</a></strong>
        <span class="tools pull-right">
            <a href="javascript:;" class="fa fa-chevron-up"></a>
            <a href="javascript:;" class="fa fa-times"></a>
        </span>
        </header>
    </section>
    <!--pagination end-->
    </div>

    <div class="col-md-4" class="addToCart">
    <!--pagination start-->
    <section class="panel">
        <header class="panel-heading">
            <strong><i class="fa fa-print"></i> &nbsp; <a href="{{url('results/viewForm')}}" style="text-transform: capitalize">Check Results</a></strong>
        <span class="tools pull-right">
            <a href="javascript:;" class="fa fa-chevron-up"></a>
            <a href="javascript:;" class="fa fa-times"></a>
        </span>
        </header>
    </section>
    <!--pagination end-->
    </div>

    <div class="col-md-4" class="addToCart">
    <!--pagination start-->
    <section class="panel">
        <header class="panel-heading">
            <strong><i class="fa fa-th-large"></i> &nbsp; <a href="{{url('courseregistration/download')}}" style="text-transform: capitalize">Download Registered Courses</a></strong>
        <span class="tools pull-right">
            <a href="javascript:;" class="fa fa-chevron-up"></a>
            <a href="javascript:;" class="fa fa-times"></a>
        </span>
        </header>
    </section>
    <!--pagination end-->
    </div>

    <div class="col-md-4" class="addToCart">
    <!--pagination start-->
    <section class="panel">
        <header class="panel-heading">
            <strong><i class="fa fa-briefcase"></i> &nbsp; <a href="{{url('carryover/')}}" style="text-transform: capitalize">Carry Over Registration</a></strong>
        <span class="tools pull-right">
            <a href="javascript:;" class="fa fa-chevron-up"></a>
            <a href="javascript:;" class="fa fa-times"></a>
        </span>
        </header>
    </section>
    <!--pagination end-->
    </div>
    
    <div class="col-md-4" class="addToCart">
    <!--pagination start-->
    <section class="panel">
        <header class="panel-heading">
            <strong><i class="fa fa-user-plus"></i> &nbsp; <a href="{{url('carryover/')}}" style="text-transform: capitalize">Carry Over Upload</a></strong>
        <span class="tools pull-right">
            <a href="javascript:;" class="fa fa-chevron-up"></a>
            <a href="javascript:;" class="fa fa-times"></a>
        </span>
        </header>
    </section>
    <!--pagination end-->
    </div>
    
    
{% endblock %}