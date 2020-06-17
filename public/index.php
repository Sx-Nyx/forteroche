<?php

use Framework\Routing\Router;

require "../vendor/autoload.php";

const NAMESPACE_CONTROLLER = 'App\Controller\\';

$router = (new Router('templates\notfound.php'))
        ->get('/', NAMESPACE_CONTROLLER . 'HomeController::index', 'home')
        ->get('/:slug', NAMESPACE_CONTROLLER . 'NovelController::index', 'novel.index')
        ->listen();

