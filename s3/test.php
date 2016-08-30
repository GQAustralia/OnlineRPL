<?php

function sendJson($arr)
{
    header('Content-Type: application/json');
    die(json_encode($arr));
}


require 'vendor/autoload.php';
require 'config.php';
require 'database.php';

$pdoObject->createJob('1472049324662-w8zz0c');


/**
 * Created by PhpStorm.
 * User: samir.mohapatra
 * Date: 08/24/2016
 * Time: 08:06:05 PM
 */