<?php

namespace App\Controller\Admin;

use App\Repository\CommentRepository;
use Framework\Database\Connection;
use Framework\Routing\Router;

class CommentController
{
    public static function index(Router $router)
    {
        $comments = (new CommentRepository(Connection::getPDO()))->findAllReported();
        var_dump($comments);
    }
}
