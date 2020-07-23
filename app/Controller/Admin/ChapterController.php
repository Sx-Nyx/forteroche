<?php

namespace App\Controller\Admin;

use App\Entity\Chapter;
use App\Repository\ChapterRepository;
use App\Repository\NovelRepository;
use DateTime;
use Framework\Controller\AbstractAdminController;
use Framework\Database\Connection;
use Framework\Database\Exception\NotFoundException;
use Framework\Helper\Form;
use Framework\Rendering\Exception\ViewRenderingException;
use Framework\Routing\Exception\RouteNotFoundException;
use Framework\Routing\Router;
use Framework\Server\Response;
use Framework\Session\FlashMessage;
use Framework\Session\Session;
use Framework\Validator\Validator;

class ChapterController extends AbstractAdminController
{
    /**
     * @var string $viewBasePath
     */
    protected $viewBasePath = 'templates/admin/chapter/';

    /**
     * @var Router
     */
    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
        parent::__construct($router);
    }

    /**
     * @param array $parameters
     * @return string
     * @throws RouteNotFoundException
     * @throws ViewRenderingException
     */
    public function new(array $parameters)
    {
        $this->authSecurity();
        $pdo = Connection::getPDO();
        $novel = $this->findBy(new NovelRepository($pdo), 'slug', $parameters[0]);
        $chapter = new Chapter(new Validator(array_merge($_POST, ['novelId' => $novel->getId()]), $pdo));
        if (!empty($_POST)) {
            $data = [
                'novelId' => $novel->getId(),
                'slug' => $_POST['title'],
                'status' => !empty($_POST['online']),
                'created_at' => new DateTime(date('Y-m-d H:i:s'))
            ];
            $this->hydrateEntity($chapter, array_merge($data, $_POST), ['title', 'content', 'slug', 'novelId', 'status', 'created_at']);
            if (empty($chapter->getErrors())) {
                (new ChapterRepository($pdo))->createChapter($chapter);
                FlashMessage::success('Le chapitre a bien été crée.');
                Response::redirection($this->router->generateUrl('admin.novel'));
            }
        }
        return $this->render('new', [
            'chapter' => $chapter,
            'form' => new Form($chapter)
        ]);
    }

    /**
     * @param array $parameters
     * @return string
     * @throws RouteNotFoundException
     * @throws ViewRenderingException
     */
    public function edit(array $parameters)
    {
        $this->authSecurity();
        $pdo = Connection::getPDO();
        $chapter = $this->findBy(new ChapterRepository($pdo), 'id', $parameters[1]);
        if (!empty($_POST)) {
            $data = [
                'id' => $chapter->getId(),
                'slug' => $_POST['title'],
                'status' => !empty($_POST['online']),
            ];
            $updatedChapter = new Chapter(new Validator($_POST, $pdo));
            $this->hydrateEntity($updatedChapter, array_merge($data, $_POST), ['id', 'title', 'content', 'slug', 'status']);
            if (empty($updatedChapter->getErrors())) {
                (new ChapterRepository(Connection::getPDO()))->updateChapter($updatedChapter);
                FlashMessage::success('Le chapitre a bien été modifier.');
                Response::redirection($this->router->generateUrl('admin.novel'));
            }
        }
        $chapter = isset($updatedChapter) ? $updatedChapter : $chapter;
        return $this->render('edit', [
            'form' => new Form($chapter)
        ]);
    }

    /**
     * @param array $parameters
     * @throws RouteNotFoundException
     */
    public function delete(array $parameters)
    {
        $this->authSecurity();
        (new ChapterRepository(Connection::getPDO()))->delete($parameters[0]);
        FlashMessage::success('Le chapitre a bien été supprimer.');
        Response::redirection($this->router->generateUrl('admin.novel'));
    }
}
