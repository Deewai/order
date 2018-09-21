<?php
// required headers
header("Access-Control-Allow-Origin: *");
// header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


// show error reporting for dev
ini_set('display_errors', 1);
error_reporting(E_ALL);
include 'vendor/autoload.php';
include __DIR__.'/config/routes.php';