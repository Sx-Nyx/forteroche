<?php

namespace App\Controller;

use Framework\Rendering\Renderer;
use Framework\Routing\Router;

class NovelController
{
    public static function index(Router $router, array $slug)
    {
        $renderer = new Renderer("../templates/base.php");
        $renderer->render("../templates/novel/index.php");
    }
}
