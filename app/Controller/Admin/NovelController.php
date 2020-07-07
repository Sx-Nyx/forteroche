<?php

namespace App\Controller\Admin;

use App\Repository\ChapterRepository;
use App\Repository\NovelRepository;
use Framework\Database\Connection;
use Framework\Rendering\Renderer;
use Framework\Routing\Router;

class NovelController
{
    public static function index(Router $router)
    {
        $pdo = Connection::getPDO();
        $novel = (new NovelRepository($pdo))->findLatest();
        $chapters = (new ChapterRepository($pdo))->findAllBy($novel->getId());

        $renderer = new Renderer("../templates/admin/base.php");
        $renderer->render("../templates/admin/novel/index.php", [
            'router'    => $router,
            'novel'     => $novel,
            'chapters'     => $chapters
        ]);
    }

    public static function edit(Router $router)
    {
        $renderer = new Renderer("../templates/admin/base.php");
        $renderer->render("../templates/admin/novel/show.php", [
            'router'    => $router,
        ]);
    }
}
