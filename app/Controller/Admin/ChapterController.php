<?php

namespace App\Controller\Admin;

use App\Repository\NovelRepository;
use Framework\Database\Connection;
use Framework\Rendering\Renderer;
use Framework\Routing\Router;

class ChapterController
{
    public static function new(Router $router, array $parameters)
    {
        $renderer = new Renderer("../templates/admin/base.php");
        $renderer->render("../templates/admin/chapter/new.php", [
            'router'    => $router,
        ]);
    }
}
