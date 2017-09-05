<?php
session_start();

require_once "autoload.php";

use Controller\UserController;
use Controller\AppController;
use Controller\MessageController;

if (isset($_GET['ctrl']) && isset($_GET['act'])) {
    $controller = $_GET['ctrl'];
    $action     = $_GET['act'];
} else {
    $controller = 'app';
    $action     = 'home';
}

if(!isset($_SESSION['username'])){
    $controller = 'user';
    $action     = 'login';
}

function call($controller, $action) {
    require_once('Controller/' . $controller . '_controller.php');

    switch($controller) {
        case 'user':
            $controller = new UserController();
            break;
        case 'app':
            $controller = new AppController();
            break;
        case 'message':
            $controller = new MessageController();
            break;
    }
    $controller->{ $action }();
}


$controllers = [
    'app' => ['home', 'error404'],
    'user' => ['login', 'logout','connected'],
    'message' => ['create','refresh']
    ];


if (array_key_exists($controller, $controllers) AND in_array($action, $controllers[$controller]))
    call($controller, $action);
else
    call('app', 'error404');

