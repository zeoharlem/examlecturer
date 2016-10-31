<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

date_default_timezone_set('utc');

$config = new \Phalcon\Config(array(
    'db' => array(
        'host' => 'localhost',
        'username' => 'root',
        'password' => '',
        'dbname' => 'students'
    ),
    'environment' => 'staging'
));

$api = new \Phalcon\Config(array());