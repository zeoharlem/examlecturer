<!DOCTYPE html>
<html class="no-js" lang="en">
    <head>
        {{ get_title()}}
        <meta charset="utf-8">
        <title>School Portal</title>
        <meta content="IE=edge" http-equiv="X-UA-Compatible">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        
        {{ this.assets.outputCss('headers') }}
        {% block head %}
        {% endblock %}
        <link href="favicon.ico" rel="shortcut icon">
    </head>
    <body>
    <!-- BEGIN HEADER -->
    <section id="container">
    <!--header start-->
    <header class="header fixed-top clearfix">
    <!--logo start-->
    <div class="brand">

        <a href="?type=&action=default" class="logo">
            <img src="{{url('assets/images/logo.png')}}" alt="">
        </a>
        <div class="sidebar-toggle-box">
            <div class="fa fa-bars"></div>
        </div>
    </div>
    <!--logo end-->

    <div class="nav notify-row" id="top_menu">
        <!--  notification start -->
        <ul class="nav top-menu">
            <!-- settings start -->
            <li class="dropdown" title="Send a mail to lecturer">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <i class="fa fa-envelope fa-2x"></i>
                </a>

            </li>
            <!-- settings end -->
            <!-- inbox dropdown start-->
            <li id="header_inbox_bar" class="dropdown" title="Carry Over Registration">
                <a href="">
                    <i class="fa fa-plus fa-2x"></i>
                </a>

            </li>
            <!-- inbox dropdown end -->
            <!-- notification dropdown start-->
            <li id="header_notification_bar" class="dropdown" title="Course Registration">
                <a href="">

                    <i class="fa fa-user-plus fa-2x"></i>
                </a>

            </li>
            

            <!--<li class="dropdown" title="CGPA calculation">
                <a class="dropdown-toggle" href="">

                    <i class="fa fa-line-chart fa-2x"></i>
                </a>

            </li>-->

            <li class="dropdown" title="Phone contacts">
                <a class="dropdown-toggle" href="">

                    <i class="fa fa-phone fa-2x"></i>
                </a>

            </li>

            <li class="dropdown" title="Course Packages">
                <a class="dropdown-toggle" href="">

                    <i class="fa fa-hdd-o fa-2x"></i>
                </a>

            </li>
            <!-- notification dropdown start-->
            <!--
            <li id="header_notification_bar" class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">

                    <i class="fa fa-bell-o fa-2x"></i>
                    <span class="badge bg-success">3</span>
                </a>
                <ul class="dropdown-menu extended notification">
                    <li>
                        <p>Notifications</p>
                    </li>
                    <li>
                        <div class="alert alert-info clearfix">
                            <span class="alert-icon"><i class="fa fa-bolt"></i></span>
                            <div class="noti-info">
                                <a href="#"> Server #1 overloaded.</a>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="alert alert-danger clearfix">
                            <span class="alert-icon"><i class="fa fa-bolt"></i></span>
                            <div class="noti-info">
                                <a href="#"> Server #2 overloaded.</a>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="alert alert-success clearfix">
                            <span class="alert-icon"><i class="fa fa-bolt"></i></span>
                            <div class="noti-info">
                                <a href="#"> Server #3 overloaded.</a>
                            </div>
                        </div>
                    </li>

                </ul>
            </li>-->
            <!-- notification dropdown end -->
            <!-- notification dropdown end -->
        </ul>
    </div>
    <div class="top-nav clearfix">
        <!--search & user info start-->
        <ul class="nav pull-right top-menu">
            <li>
                <input type="text" class="form-control search" placeholder=" Search">
            </li>
            <!-- user login dropdown start-->
            <li class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <img alt="" src="{{url('/assets/images/avatar1_small.jpg')}}">
                    <span class="username">{{session.get('auth')['firstname'] | capitalize}}</span>
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu extended logout">
                    <li><a href=""><i class=" fa fa-suitcase"></i>Profile</a></li>
                    <li><a href=""><i class="fa fa-cog"></i> Settings</a></li>
                    <li><a href="{{url('index/logOut')}}"><i class="fa fa-key"></i> Sign Out</a></li>
                </ul>
            </li>
            <!-- user login dropdown end -->

        </ul>
        <!--search & user info end-->
    </div>
    </header>
    <!--header end-->

    <!--sidebar start-->
    <aside>
    <div id="sidebar" class="nav-collapse">
        <!-- sidebar menu start-->
        <div class="leftside-navigation">
            <ul class="sidebar-menu" id="nav-accordion">
                <li>
                    <a class="active" href="#">
                        <i class="fa fa-dashboard"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                
                <!--<li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-edit"></i>
                        <span>Courses</span>
                    </a>
                    <ul class="sub">
                        <li class="active"><a href="{{url('course/')}}">Create Courses</a></li>
                        <li><a href="{{url('course/show')}}">Edit/Delete Courses</a></li>
                        <li><a href="{{url('course/department')}}">Create Department</a></li>
                    </ul>
                </li>
                
                
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-hdd-o"></i>
                        <span>Session Packages</span>
                    </a>
                    <ul class="sub">
                        <li class="active"><a href="{{url('packages/')}}">Create Packages</a></li>
                        <li><a href="{{url('packages/show')}}">Edit/Delete Packages</a></li>
                    </ul>
                </li>
                -->
                
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-user-plus"></i>
                        <span>Course Registration</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{url('students')}}">View Students</a></li>
                        <li class="active"><a href="{{url('courseregistration/download')}}">Download Registered Courses</a></li>
                        <li><a href="{{url('carryover/')}}">Carry Over Registration</a></li>

                    </ul>
                </li>
                
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-th-large"></i>
                        <span>Results</span>
                    </a>
                    <ul class="sub">
                        <li class="active"><a href="{{url('results')}}">Upload Results</a></li>
                        <li class="active"><a href="{{url('results/viewForm')}}">Check Results</a></li>
                        <li><a href="{{url('carryover/')}}">Carry Over Upload</a></li>
                    </ul>
                </li>
                
                
                <!--<li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-user-plus"></i>
                        <span>Lecturer</span>
                    </a>
                    <ul class="sub">
                        <li class="active"><a href="{{url('lecturer/')}}">Create Lecturer</a></li>
                        <li class="active"><a href="{{url('lecturer/assign')}}">Assign Courses</a></li>
                    </ul>
                </li>-->
                
                <li>
                    <a href="{{url('')}}">
                        <i class="fa fa-envelope"></i>
                        <span>Contact | Mail</span>
                    </a>
                </li>
                
                <li>
                    <a href="{{url('index/logOut')}}">
                        <i class="fa fa-power-off"></i>
                        <span>Sign Out</span>
                    </a>
                </li>
            </ul>            </div>
        <!-- sidebar menu end-->
    </div>
</aside>
<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper">
    <!-- page start-->

    <div class="row">
    <div class="col-sm-12">{{flash.output()}}</div>
    {% block content %}
        
    {% endblock %}
    </div>
    <!-- page end-->
    </section>
</section>
<!--main content end-->
</section>
{{ this.assets.outputJs('footers') }}
    </body>
</html>