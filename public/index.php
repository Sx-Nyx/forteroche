<?php

use Framework\Routing\Router;

chdir(dirname(__DIR__));

require "vendor/autoload.php";

const NAMESPACE_CONTROLLER = 'App\Controller\\';

$router = (new Router('templates\notfound.php'))
    // LOGIN
     ->get('/login', NAMESPACE_CONTROLLER . 'LoginController::index', 'login')
     ->post('/login', NAMESPACE_CONTROLLER . 'LoginController::login', 'login.attempt')
     ->get('/logout', NAMESPACE_CONTROLLER . 'LoginController::logout', 'logout')

    // ADMIN_NOVEL
    ->get('/admin', NAMESPACE_CONTROLLER . 'Admin\NovelController::index', 'admin.novel')
    ->get('/admin/roman/:slug/:id', NAMESPACE_CONTROLLER . 'Admin\NovelController::show', 'admin.novel.show')
    ->post('/admin/roman/:slug/:id', NAMESPACE_CONTROLLER . 'Admin\NovelController::edit', 'admin.novel.edit')

    // ADMIN_CHAPTER
    ->post('/admin/chapitres/:id', NAMESPACE_CONTROLLER . 'Admin\ChapterController::delete', 'admin.chapter.delete')
    ->get('/admin/chapitre/:slug/new', NAMESPACE_CONTROLLER . 'Admin\ChapterController::new', 'admin.chapter.new')
    ->post('/admin/chapitre/:slug/new', NAMESPACE_CONTROLLER . 'Admin\ChapterController::new', 'admin.chapter.new')
    ->get('/admin/chapitre/:slug/edit/:id', NAMESPACE_CONTROLLER . 'Admin\ChapterController::edit', 'admin.chapter.edit')
    ->post('/admin/chapitre/:slug/edit/:id', NAMESPACE_CONTROLLER . 'Admin\ChapterController::edit', 'admin.chapter.edit')

    // ADMIN_COMMENT
    ->get('/admin/commentaires', NAMESPACE_CONTROLLER . 'Admin\CommentController::index', 'admin.comment')
    ->get('/admin/commentaire/:id', NAMESPACE_CONTROLLER . 'Admin\CommentController::show', 'admin.comment.show')
    ->post('/admin/commentaire/edit/:id', NAMESPACE_CONTROLLER . 'Admin\CommentController::edit', 'admin.comment.edit')
    ->post('/admin/commentaire/:id', NAMESPACE_CONTROLLER . 'Admin\CommentController::delete', 'admin.comment.delete')

    ->get('/', NAMESPACE_CONTROLLER . 'HomeController::index', 'home')
    ->get('/:slug', NAMESPACE_CONTROLLER . 'NovelController::index', 'novel.index')
    ->get('/:novelSlug/:chapterSlug', NAMESPACE_CONTROLLER . 'NovelController::show', 'novel.show')
    ->post('/:novelSlug/:chapterSlug', NAMESPACE_CONTROLLER . 'CommentController::new', 'comment.new')
    ->post('/:novelSlug/:chapterSlug/:id', NAMESPACE_CONTROLLER . 'CommentController::report', 'comment.report')

    ->listen();
