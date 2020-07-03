<?php

namespace App\Controller;

use App\Repository\NovelRepository;
use Framework\Database\Connection;
use Framework\Rendering\Renderer;
use Framework\Routing\Router;

class HomeController
{
    public static function index(Router $router):void
    {
        $novel = (new NovelRepository(Connection::getPDO()))->findLatest();
        $renderer = new Renderer("../templates/base.php");
        $renderer->render("../templates/home/index.php", [
            'novel'     => $novel,
            'novelSlug' => $novel->getSlug(),
            'router' => $router
        ]);
    }
}
