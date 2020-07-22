<?php

namespace App\Controller\Admin;

use App\Entity\Chapter;
use App\Repository\ChapterRepository;
use App\Repository\NovelRepository;
use DateTime;
use Framework\Controller\AbstractAdminController;
use Framework\Database\Connection;
use Framework\Database\Exception\NotFoundException;
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
     * @throws NotFoundException
     * @throws RouteNotFoundException
     * @throws ViewRenderingException
     */
    public function new(array $parameters)
    {
        $this->authSecurity();
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
                return $this->render('new', [
                    'errors'    => $chapter->getErrors(),
                    'novel'     => $novel
                ]);
            } else {
                (new ChapterRepository($pdo))->createChapter($chapter);
                FlashMessage::success('Le chapitre a bien été créer');
                return $this->render('new', [
                    'novel'     => $novel
                ]);
            }
        } else {
            $chapter = new Chapter();
            return $this->render('new', [
                'novel'     => $novel,
                'chapter'   => $chapter
            ]);
        }
    }

    /**
     * @param array $parameters
     * @return string
     * @throws NotFoundException
     * @throws RouteNotFoundException
     * @throws ViewRenderingException
     */
    public function edit(array $parameters)
    {
        $this->authSecurity();
        $pdo = Connection::getPDO();
        $chapter = (new ChapterRepository($pdo))->findBy('id', $parameters[1]);
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
                return $this->render('edit', [
                    'errors' => $chapter->getErrors(),
                    'chapter'   => $chapter
                ]);
            } else {
                (new ChapterRepository($pdo))->updateChapter($chapter);
                FlashMessage::success('Le chapitre a bien été modifier');
                Response::redirection($this->router->generateUrl("admin.chapter.edit", ['slug' => $parameters[0], 'id' => $parameters[1]]));
            }
        }
        return $this->render('edit', [
            'chapter' => $chapter
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
        Response::redirection($this->router->generateUrl('admin.novel'));
    }
}
