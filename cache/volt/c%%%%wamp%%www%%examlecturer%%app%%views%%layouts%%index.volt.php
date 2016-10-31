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
        <style type="text/css">.jqstooltip { position: absolute;left: 0px;top: 0px;visibility: hidden;background: rgb(0, 0, 0) transparent;background-color: rgba(0,0,0,0.6);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000);-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000)";color: white;font: 10px arial, san serif;text-align: left;white-space: nowrap;padding: 5px;border: 1px solid white;z-index: 10000;}.jqsfield { color: white;font: 10px arial, san serif;text-align: left;}</style>
    </head>
    <body class="login-body">

    <div class="container">

      <form class="form-signin" method="post" action="<?php echo $this->url->get('index'); ?>">
        <h2 class="form-signin-heading"><strong>School</strong> Portal</h2>
        <div class="login-wrap">
        <?php echo $this->flash->output(); ?>
            <div class="user-login-info">
                <input type="text" name="username" class="form-control" placeholder="Enter Your Username" autofocus>
                <input type="password" name="password" class="form-control" placeholder="Type your Password">
            </div>
            <label class="checkbox">
                <input type="checkbox" value="remember-me"> Remember me
                <span class="pull-right">
                    <a data-toggle="modal" href="#myModal"> Forgot Password?</a>

                </span>
            </label>
            <button class="btn btn-lg btn-login btn-block" type="submit">Sign in</button>


        </div>
      </form>

    </div>
    <?php echo $this->assets->outputJs('footers'); ?>
    </body>
</html>