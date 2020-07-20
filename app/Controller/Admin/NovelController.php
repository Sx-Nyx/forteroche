<?php

namespace App\Controller\Admin;

use App\Entity\Novel;
use App\Repository\ChapterRepository;
use App\Repository\NovelRepository;
use Framework\Database\Connection;
use Framework\Rendering\Renderer;
use Framework\Routing\Router;
use Framework\Security\Authentification;
use Framework\Server\Response;
use Framework\Session\FlashMessage;
use Framework\Session\Session;
use Framework\Validator\Validator;

class NovelController
{
    public static function index(Router $router)
    {
        Authentification::verify();
        $pdo = Connection::getPDO();
        $novel = (new NovelRepository($pdo))->findLatest();
        $chapters = (new ChapterRepository($pdo))->findAllBy($novel->getId());

        $renderer = new Renderer("../templates/admin/base.php");
        $renderer->render("../templates/admin/novel/index.php", [
            'router'    => $router,
            'novel'     => $novel,
            'chapters'  => $chapters
        ]);
    }

    public static function show(Router $router, array $parameters)
    {
        Authentification::verify();
        $novel = (new NovelRepository(Connection::getPDO()))->findBy('slug', $parameters[0]);
        $renderer = new Renderer("../templates/admin/base.php");
        $renderer->render("../templates/admin/novel/show.php", [
            'router'    => $router,
            'novel'     => $novel
        ]);
    }

    public static function edit(Router $router, array $parameters)
    {
        Authentification::verify();
        $pdo = Connection::getPDO();
        $novel = (new Novel(new Validator($_POST, $pdo)))
            ->setId($parameters[1])
            ->setTitle($_POST['titre'], (int)$parameters[1])
            ->setDescription($_POST['description'])
            ->setSlug($_POST['titre']);
        if (!empty($novel->getErrors())) {
            Session::set('title', $novel->getTitle());
            Session::set('description', $novel->getDescription());
            $renderer = new Renderer("../templates/admin/base.php");
            $renderer->render("../templates/admin/novel/show.php", [
                'router'    => $router,
                'errors'    => $novel->getErrors(),
                'novel'     => (new NovelRepository($pdo))->findBy('id', $parameters[1])
            ]);
        } else {
            (new NovelRepository($pdo))->updateNovel($novel);
            FlashMessage::success('Le roman a bien été modifier');
            Response::redirection($router->generateUrl('admin.novel.show',
                ['slug' => $novel->getSlug(), 'id' => $novel->getId()]));
        }
    }
}
