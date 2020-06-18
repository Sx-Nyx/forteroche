<?php

namespace App\Controller;

use App\Repository\ChapterRepository;
use App\Repository\NovelRepository;
use Framework\Database\Connection;
use Framework\Rendering\Renderer;
use Framework\Routing\Router;

class NovelController
{
    public static function index(Router $router, array $slug)
    {
        $novel = (new NovelRepository(Connection::getPDO()))->findBy($slug[0]);
        $chapters = (new ChapterRepository(Connection::getPDO()))->findAndCount($novel->getId());

        $renderer = new Renderer("../templates/base.php");
        $renderer->render("../templates/novel/index.php", [
            'router'    => $router,
            'novel'     => $novel,
            'chapters'  => $chapters
        ]);
    }
}
