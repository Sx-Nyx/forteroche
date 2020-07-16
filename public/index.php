<?php

use Framework\Routing\Router;

require "../vendor/autoload.php";

const NAMESPACE_CONTROLLER = 'App\Controller\\';

$router = (new Router('templates\notfound.php'))
    ->get('/admin', NAMESPACE_CONTROLLER . 'Admin\NovelController::index', 'admin.novel')
    ->get('/admin/:slug/:id', NAMESPACE_CONTROLLER . 'Admin\NovelController::show', 'admin.novel.show')
    ->post('/admin/:slug/:id', NAMESPACE_CONTROLLER . 'Admin\NovelController::edit', 'admin.novel.edit')

    ->get('/admin/:slug/chapter/new', NAMESPACE_CONTROLLER . 'Admin\ChapterController::new', 'admin.chapter.new')
    ->post('/admin/:slug/chapter/new', NAMESPACE_CONTROLLER . 'Admin\ChapterController::new', 'admin.chapter.new')
    ->get('/admin/:slug/chapter/edit/:id', NAMESPACE_CONTROLLER . 'Admin\ChapterController::edit', 'admin.chapter.edit')
    ->post('/admin/:slug/chapter/edit/:id', NAMESPACE_CONTROLLER . 'Admin\ChapterController::edit', 'admin.chapter.edit')

    ->get('/', NAMESPACE_CONTROLLER . 'HomeController::index', 'home')
    ->get('/:slug', NAMESPACE_CONTROLLER . 'NovelController::index', 'novel.index')
    ->get('/:novelSlug/:chapterSlug', NAMESPACE_CONTROLLER . 'NovelController::show', 'novel.show')
    ->post('/:novelSlug/:chapterSlug', NAMESPACE_CONTROLLER . 'CommentController::new', 'comment.new')
    ->post('/:novelSlug/:chapterSlug/:id', NAMESPACE_CONTROLLER . 'CommentController::report', 'comment.report')

    ->listen();
