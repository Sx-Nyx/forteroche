<?php

namespace App\Controller;

use App\Repository\ChapterRepository;
use App\Repository\NovelRepository;
use Framework\Database\Connection;
use Framework\Rendering\Renderer;
use Framework\Routing\Router;

class NovelController
{
    public static function index(Router $router, array $parameters)
    {
        $pdo = Connection::getPDO();

        $novel = (new NovelRepository($pdo))->findBy($parameters[0]);
        $chapters = (new ChapterRepository($pdo))->findAndCount($novel->getId());

        $renderer = new Renderer("../templates/base.php");
        $renderer->render("../templates/novel/index.php", [
            'router'    => $router,
            'novel'     => $novel,
            'chapters'  => $chapters
        ]);
    }

    public static function show(Router $router, array $parameters)
    {
        $pdo = Connection::getPDO();

        $chapter = (new ChapterRepository($pdo))->find($parameters[1]);

        $renderer = new Renderer("../templates/base.php");
        $renderer->render("../templates/novel/show.php", [
            'chapter'   => $chapter
        ]);
    }
}
