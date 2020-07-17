<?php

namespace App\Controller\Admin;

use App\Repository\CommentRepository;
use Framework\Database\Connection;
use Framework\Rendering\Renderer;
use Framework\Routing\Router;

class CommentController
{
    public static function index(Router $router)
    {
        $comments = (new CommentRepository(Connection::getPDO()))->findAllReported();
        $renderer = new Renderer("../templates/admin/base.php");
        $renderer->render("../templates/admin/comment/index.php", [
            'router'    => $router,
            'comments'     => $comments,
        ]);
    }

    public static function show(Router $router, array $parameters)
    {
        $comment = (new CommentRepository(Connection::getPDO()))->findBy('id', $parameters[0]);
        $renderer = new Renderer("../templates/admin/base.php");
        $renderer->render("../templates/admin/comment/show.php", [
            'router'    => $router,
            'comment'     => $comment,
        ]);
    }
}
