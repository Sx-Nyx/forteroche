<?php

namespace App\Controller;

use Framework\Rendering\Renderer;

class HomeController
{
    public static function index()
    {
        $renderer = new Renderer("../templates/base.php");
        $renderer->render("../templates/home/index.php");
    }
}
