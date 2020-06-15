<?php

use Framework\Routing\Router;

require "../vendor/autoload.php";

const CONTROLLER_NAMESPACE = "App\Controller\\";

$router = new Router('templates\notfound.php');
$router->get('/', "App\Controller\HomeController::index", 'home');
$router->listen();
