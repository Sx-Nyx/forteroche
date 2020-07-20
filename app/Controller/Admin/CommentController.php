<?php

namespace App\Controller\Admin;

use App\Repository\CommentRepository;
use Framework\Database\Connection;
use Framework\Rendering\Renderer;
use Framework\Routing\Router;
use Framework\Security\Authentification;
use Framework\Server\Response;

class CommentController
{
    public static function index(Router $router)
    {
        Authentification::verify();
        $comments = (new CommentRepository(Connection::getPDO()))->findAllReported();
        $renderer = new Renderer("../templates/admin/base.php");
        $renderer->render("../templates/admin/comment/index.php", [
            'router'    => $router,
            'comments'     => $comments,
        ]);
    }

    public static function show(Router $router, array $parameters)
    {
        Authentification::verify();
        $comment = (new CommentRepository(Connection::getPDO()))->findBy('id', $parameters[0]);
        $renderer = new Renderer("../templates/admin/base.php");
        $renderer->render("../templates/admin/comment/show.php", [
            'router'    => $router,
            'comment'     => $comment,
        ]);
    }

    public static function edit(Router $router, array $parameters)
    {
        Authentification::verify();
        $comment = (new CommentRepository(Connection::getPDO()))->findBy('id', $parameters[0]);
        $comment->setReported(-1);
        (new CommentRepository(Connection::getPDO()))->updateComment($comment);
        Response::redirection($router->generateUrl('admin.novel'));
    }

    public static function delete(Router $router, array $parameters)
    {
        Authentification::verify();
        (new CommentRepository(Connection::getPDO()))->delete($parameters[0]);
        Response::redirection($router->generateUrl('admin.novel'));

    }
}
