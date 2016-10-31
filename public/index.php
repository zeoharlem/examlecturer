<?php
/**
 * Creating the Boostrapping Application
 * All Boostrapping Activities Starts here
 */
session_name('examlecturer');

use Phalcon\Config\Adapter\Ini as ConfigIni;
use Neodynamic\SDK\Web\WebClientPrint as WebPrint;
//use Phalcon\Mvc\Model\Manager;

require '../app/config/Config.php';

try{
    define('APP_PATH', realpath('..') . DIRECTORY_SEPARATOR);
    
    //Line Reads the configuration ini file
    $config = new ConfigIni(APP_PATH . 'app/config/config.ini');
    //Starting the Autoloader
    $loader = new \Phalcon\Loader();
    $loader->registerDirs(array(
        APP_PATH.$config->application->formsDir,
        APP_PATH.$config->application->pluginsDir,
        APP_PATH.$config->application->libraryDir,
        APP_PATH.$config->application->controllersDir,
        APP_PATH.$config->application->modelsDir,
        APP_PATH.$config->application->configDir
    ));
    
    $loader->registerClasses(array(
        'Component\User' => '../app/components/User.php',
        'Component\Helper' => '../app/components/Helper.php',
        'Component\UserChange' => '../app/components/UserChange.php',
    ));
    
    $loader->registerNamespaces(array(
        'DataTables'    => __DIR__ . '/../vendor/m1ome/phalcon-datatables/src/'
    ));
    
    $loader->register();
    
    //Settings for mailer service
    $settings = array(
        'driver'    => 'mail',
        'from'      => array(
            'email' => 'info@dominicaninstitute.org',
            'name'  => 'Dominican Institute'
        )
    );
    
    //DataTable server settings 
    
    //Dependencies Injection
    $di = new \Phalcon\Di\FactoryDefault();
    
    //Return API config
    $di->setShared('config', function() use ($config){
        return $config;
    });
    
    //Return API config
    $di->setShared('api', function() use ($api){
        return $api;
    });
    
    $di->setShared('webclientprint', function(){
        
    });
    
    //Database connection Dependencies
    $di->set('db', function() use ($di){
        $dbConfig = $di->get('config')->get('db')->toArray();
        //Use the database configure in the config file 
        $db = new \Phalcon\Db\Adapter\Pdo\Mysql($dbConfig);
        return $db;
    });
    
    //Set PHPExcel worksheet class
    $di->set('PHPExcel', function() use ($di){
        $PHPExcel = new \PHPExcel();
        return $PHPExcel;
    });
    
    //Establish the security level
    $di->set('security', function(){
        $security = new \Phalcon\Security();
        //$security->setWorkFactor(12);
        return $security;
    }, true);
    
    //Set the view directories
    $di->set('view', function() use($config){
        $view = new \Phalcon\Mvc\View();
        //$view->setViewsDir('../app/views');
        $view->setViewsDir(APP_PATH . $config->application->viewsDir);
        $view->registerEngines(array(".volt" => 'volt'));
        return $view;
    });
    
    //Setting up the volt cache engine
    $di->set('volt', function($view, $di){
        $volt = new \Phalcon\Mvc\View\Engine\Volt($view, $di);
        $volt->setOptions(array('compiledPath' => APP_PATH . 'cache/volt/'));
        $compiler = $volt->getCompiler();
        $compiler->addFunction('num_format', 'number_format');
        $compiler->addFunction('build_query_http', 'http_build_query');
        $compiler->addFunction('getGrade', function($resolveArgs, $exprArgs){
            //use $resolvedArgs to pass the arguments exactly as 
            return 'GradePoints::__gradeParser('.$resolveArgs.')';
        });
        $compiler->addFunction('getResults', function($resolveArgs, $exprArgs){
            //use $resolvedArgs to pass the arguments exactly
            return 'GradePoints::__getResults('.$resolveArgs.')';
        });
        $compiler->addFunction('__getOtherSemester', function($resolveArgs, $exprArgs){
            //use $resolvedArgs to pass the arguments exactly
            return 'GradePoints::__getResults('.$resolveArgs.')';
        });
        return $volt;
    }, true);
    
    //Set session
    $di->setShared('session', function(){
        $session = new \Phalcon\Session\Adapter\Files();
        $session->start();
        return $session;
    });
    
    //Return custom components
    $di->setShared('component', function(){
        $obj = new stdClass();
        $obj->helper = new \Component\Helper;
        $obj->user = new \Component\User;
        return $obj;
    });
    
    //Encryption start ups
    $di->setShared('crypt', function() use($di){
        $crypt  = new \Phalcon\Crypt();
        $key    = $di->getShared('component')->helper->makeRandomString(15);
        //$crypt->setMode(MCRYPT_MODE_CFB);
        $crypt->setKey($key);
        return $crypt;
    });
    
    //Cookies start ups
    $di->setShared('cookies', function(){
        $cookies    = new \Phalcon\Http\Response\Cookies();
        return $cookies;
    });
    
    //Mail service function component
    $di->set('mail', function() use ($settings){
        $mail = new Phalcon\Ext\Mailer\Manager($settings);
        return $mail;
    });
	
    //Flash Data(Temporary Data)
    $di->set('flash', function(){
        $flash = new \Phalcon\Flash\Session(array(
            'error' => 'alert alert-danger',
            'success' => 'alert alert-success',
            'notice' => 'alert alert-info',
            'warning' => 'alert alert-warning'
        ));
        return $flash;
    });
    
    //Model Event Manager
    $di->set('modelsManager', function(){
        return new Phalcon\Mvc\Model\Manager();
    });
    
    //Meta-data
    $di['modesMetadata'] = function(){
        $metaData = new \Phalcon\Mvc\Model\MetaData\Apc(array(
            "lifetime"=>84600,
            "prefix"=>"metaData"
        ));
        return $metaData;
    };
    
    //Setup a base URI so that all generated URIs include the tutorial folder
    $di->set('url', function(){
        $url = new \Phalcon\Mvc\Url();
        $url->setBaseUri('/examlecturer/');
        return $url;
    });
    
    $di->setShared('dataTables', function(){
        
    });
    
    //Custom Dispatcher (Overides the Default)
    $di->set('dispatcher', function() use ($di){
        $eventsManager = $di->getShared('eventsManager');
        //Custom ACL Class
        $permission = new Permission();
        // Listen for events from the permission class
//        $eventsManager->attach('dispatch:beforeException', 
//                function($event, $dispatcher, $exception){
//                    switch($exception->getCode()){
//                        case Phalcon\Mvc\Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
//                        case Phalcon\Mvc\Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
//                            $dispatcher->forward(array(
//                                'controller'    =>  'error',
//                                'action'        =>  'notFound'
//                            ));
//                            return false;
//                            break;
//                        default : $dispatcher->forward(array(
//                            'controller'        =>  'error',
//                            'action'            =>  'uncaughtException'
//                        ));
//                    break;
//                return false;
//            }
//        });
        $eventsManager->attach('dispatch', $permission);
        
        $dispatcher = new \Phalcon\Mvc\Dispatcher();
        $dispatcher->setEventsManager($eventsManager);
        return $dispatcher;
    });
    
    //Deploy the application on the browser
    $app = new \Phalcon\Mvc\Application($di);
    echo $app->handle()->getContent();
    
} catch (\Phalcon\Exception $ex) {
    echo $ex->getMessage();
}