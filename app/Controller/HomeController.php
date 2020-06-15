<?php

namespace App\Controller;

use App\Repository\NovelRepository;
use Framework\Database\Connection;
use Framework\Rendering\Renderer;

class HomeController
{
    public static function index()
    {
        $novel = (new NovelRepository(Connection::getPDO()))->findLatest();

        $renderer = new Renderer("../templates/base.php");
        $renderer->render("../templates/home/index.php", [
            'novel' => $novel
        ]);
    }
}
