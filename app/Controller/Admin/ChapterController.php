<?php

namespace App\Controller\Admin;

use App\Entity\Chapter;
use App\Repository\ChapterRepository;
use App\Repository\NovelRepository;
use DateTime;
use Framework\Database\Connection;
use Framework\Rendering\Renderer;
use Framework\Routing\Router;
use Framework\Server\Response;
use Framework\Session\FlashMessage;
use Framework\Session\Session;
use Framework\Validator\Validator;

class ChapterController
{
    public static function new(Router $router, array $parameters)
    {
        $pdo = Connection::getPDO();
        $novel = (new NovelRepository($pdo))->findBy('slug', $parameters[0]);
        if (!empty($_POST)) {
            $status = !empty($_POST['online']);
            $chapter = (new Chapter(new Validator(array_merge($_POST, ['novel' => $novel->getId()]), $pdo)))
                ->setTitle($_POST['titre'])
                ->setContent($_POST['contenu'])
                ->setSlug($_POST['titre'])
                ->setNovelId($novel->getId())
                ->setCreatedAt(new DateTime(date('Y-m-d H:i:s')))
                ->setStatus($status);
            if (!empty($chapter->getErrors())) {
                Session::set('title', $chapter->getTitle());
                Session::set('content', $chapter->getContent());
                Session::set('status', $chapter->getStatus());
                $renderer = new Renderer("../templates/admin/base.php");
                $renderer->render("../templates/admin/chapter/new.php", [
                    'router'    => $router,
                    'errors'    => $chapter->getErrors(),
                    'novel'     => $novel
                ]);
            } else {
                (new ChapterRepository($pdo))->createChapter($chapter);
                FlashMessage::success('Le chapitre a bien été créer');
                $renderer = new Renderer("../templates/admin/base.php");
                $renderer->render("../templates/admin/chapter/new.php", [
                    'router'    => $router,
                    'novel'     => $novel
                ]);
            }
        } else {
            $chapter = new Chapter();
            $renderer = new Renderer("../templates/admin/base.php");
            $renderer->render("../templates/admin/chapter/new.php", [
                'router'    => $router,
                'novel'     => $novel,
                'chapter'   => $chapter
            ]);
        }
    }

    public static function edit(Router $router, array $parameters)
    {
        $pdo = Connection::getPDO();
        $chapter = (new ChapterRepository($pdo))->findBy('id', $parameters[1]);
        $renderer = new Renderer("../templates/admin/base.php");
        if (!empty($_POST)) {
            $status = !empty($_POST['online']);
            $chapter = (new Chapter(new Validator($_POST, $pdo)))
                ->setId($parameters[1])
                ->setTitle($_POST['titre'], $parameters[1])
                ->setContent($_POST['contenu'])
                ->setSlug($_POST['titre'])
                ->setStatus($status);
            if (!empty($chapter->getErrors())) {
                Session::set('title', $chapter->getTitle());
                Session::set('content', $chapter->getContent());
                Session::set('status', $chapter->getStatus());
                $renderer->render("../templates/admin/chapter/edit.php", [
                    'router' => $router,
                    'errors' => $chapter->getErrors(),
                    'chapter'   => $chapter
                ]);
            } else {
                (new ChapterRepository($pdo))->updateChapter($chapter);
                FlashMessage::success('Le chapitre a bien été modifier');
                Response::redirection($router->generateUrl("admin.chapter.edit", ['slug' => $parameters[0], 'id' => $parameters[1]]));
            }
        }
        $renderer->render("../templates/admin/chapter/edit.php", [
            'router' => $router,
            'chapter' => $chapter
        ]);
    }

    public static function delete(Router $router, array $parameters)
    {
        (new ChapterRepository(Connection::getPDO()))->delete($parameters[0]);
        Response::redirection($router->generateUrl('admin.novel'));
    }
}
