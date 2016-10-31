<!DOCTYPE html>
<html class="no-js" lang="en">
    <head>
        <?php echo $this->tag->getTitle(); ?>
        <meta charset="utf-8">
        <title>School Portal</title>
        <meta content="IE=edge" http-equiv="X-UA-Compatible">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        
        <?php echo $this->assets->outputCss('headers'); ?>
        

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
            <img src="<?php echo $this->url->get('assets/images/logo.png'); ?>" alt="">
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
                    <img alt="" src="<?php echo $this->url->get('/assets/images/avatar1_small.jpg'); ?>">
                    <span class="username"><?php echo ucwords($this->session->get('auth')['firstname']); ?></span>
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu extended logout">
                    <li><a href=""><i class=" fa fa-suitcase"></i>Profile</a></li>
                    <li><a href=""><i class="fa fa-cog"></i> Settings</a></li>
                    <li><a href="<?php echo $this->url->get('index/logOut'); ?>"><i class="fa fa-key"></i> Sign Out</a></li>
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
                
                <li><a href="<?php echo $this->url->get('students'); ?>"><i class="fa fa-graduation-cap"></i><span>View Students</span></a></li>
                <li class="active"><a href="<?php echo $this->url->get('courseregistration/download'); ?>"><i class="fa fa-file-excel-o"></i><span>Download Registered Courses</span></a></li>
                <li><a href="<?php echo $this->url->get('carryover/'); ?>"><i class="fa fa-street-view"></i><span>Carry Over Registration</span></a></li>
                
                <li class="active"><a href="<?php echo $this->url->get('results'); ?>"><i class="fa fa-cubes"></i><span>Upload Results</span></a></li>
                <li class="active"><a href="<?php echo $this->url->get('results/viewForm'); ?>"><i class="fa fa-desktop"></i><span>Check Results</span></a></li>
                <?php  if($this->session->get('hod')){ ?>
                <li class="active"><a href="<?php echo $this->url->get('departmentResults/'); ?>"><i class="fa fa-user-plus"></i><span>Department Results</span></a></li>
                <?php } ?>
                <li><a href="<?php echo $this->url->get('carryover/'); ?>"><i class="fa fa-paper-plane-o"></i><span>Carry Over Upload</span></a></li>
                <li>
                    <a href="<?php echo $this->url->get(''); ?>">
                        <i class="fa fa-envelope"></i>
                        <span>Contact / Mail</span>
                    </a>
                </li>
                
                <li>
                    <a href="<?php echo $this->url->get('index/logOut'); ?>">
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
    <div class="col-sm-12"><?php echo $this->flash->output(); ?></div>
    
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <strong>Display Students</strong>
            </header>
            <div class="panel-body">
                <div class="position-left">
                    <form class="form-inline" method="post" action="<?php echo $this->url->get('results/getOffers'); ?>" role="form">
                    <div class="form-group">
                        
                        <select class="form-control" name="code">
                            <?php foreach ($depts as $keys => $values) { ?>
                            <option value="<?php echo $values->code; ?>"><?php echo ucwords($values->title); ?></option>
                            <?php } ?>
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
                    <input type="hidden" name="lecturer" value="<?php echo $this->session->get('auth')['codename']; ?>" />
                    <button type="submit" class="btn btn-primary"><strong>Display</strong></button>
                    <button type="reset" class="btn btn-default"><strong>Reset</strong></button>
                </form>
                </div>
            </div>
        </section>

    </div>
    <?php if (isset($comArray)) { ?>
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
                                <?php foreach ($comArray as $keys => $values) { ?>
                                <tr>
                                    <td style="border:1px solid #ddd;"><?php echo $keys + 1; ?></td>
                                    <td><?php echo ucwords($values['fullname']); ?></td>
                                    <td><?php echo $values['matric']; ?></td>
                                    <td><?php echo Phalcon\Text::upper($values['department']); ?></td>
                                    <td><?php echo $values['email']; ?><br/><small><i class="fa fa-phone"></i> <strong><?php echo $values['phone']; ?></strong></small></td>
                                    <td><?php echo $values['session']; ?></td>
                                    
                                    <td style="border:1px solid #ddd;">
                                        <div class="btn-row">
                                            <div class="btn-group">
                                                <a href="<?php echo $this->url->get('results/view?level=100&matric=' . $values['matric'] . '&session=' . $values['session']); ?>" class="btn btn-white" style=" font-size:13px;">1</a>
                                                <a href="<?php echo $this->url->get('results/view?level=200&matric=' . $values['matric'] . '&session=' . $values['session']); ?>" class="btn btn-white" style="font-size:13px;">2</a>
                                                <a href="<?php echo $this->url->get('results/view?level=300&matric=' . $values['matric'] . '&session=' . $values['session']); ?>" class="btn btn-white" style="font-size:13px;">3</a>
                                                <a href="<?php echo $this->url->get('results/view?level=400&matric=' . $values['matric'] . '&session=' . $values['session']); ?>" class="btn btn-white" style="font-size:13px;">4</a>
                                                
                                            </div>
                                        </div>    
                                    </td>
                                </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
    <?php } ?>

    </div>
    <!-- page end-->
    </section>
</section>
<!--main content end-->
</section>
<?php echo $this->assets->outputJs('footers'); ?>
    </body>
</html>