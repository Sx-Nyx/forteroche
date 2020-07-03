<?php

use Framework\Routing\Router;

require "../vendor/autoload.php";

const NAMESPACE_CONTROLLER = 'App\Controller\\';

$router = (new Router('templates\notfound.php'))
    ->get('/', NAMESPACE_CONTROLLER . 'HomeController::index', 'home')
    ->get('/:slug', NAMESPACE_CONTROLLER . 'NovelController::index', 'novel.index')
    ->get('/:novelSlug/:chapterSlug', NAMESPACE_CONTROLLER . 'NovelController::show', 'novel.show')
    ->post('/:novelSlug/:chapterSlug', NAMESPACE_CONTROLLER . 'CommentController::new', 'comment.new')
    ->post('/:novelSlug/:chapterSlug/:id', NAMESPACE_CONTROLLER . 'CommentController::report', 'comment.report')
    ->listen();
