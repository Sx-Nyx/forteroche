<?php

namespace App\Controller\Admin;

use App\Entity\Novel;
use App\Repository\ChapterRepository;
use App\Repository\NovelRepository;
use Framework\Controller\AdminAbstractController;
use Framework\Database\Connection;
use Framework\Database\Exception\NotFoundException;
use Framework\Rendering\Exception\ViewRenderingException;
use Framework\Routing\Exception\RouteNotFoundException;
use Framework\Routing\Router;
use Framework\Security\Authentification;
use Framework\Security\Exception\ForbiddenException;
use Framework\Server\Response;
use Framework\Session\FlashMessage;
use Framework\Session\Session;
use Framework\Validator\Validator;

class NovelController extends AdminAbstractController
{
    /**
     * @var string $viewBasePath
     */
    protected $viewBasePath = 'templates/admin/novel/';

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
     * @return string
     * @throws ViewRenderingException
     * @throws ForbiddenException
     */
    public function index()
    {
        Authentification::verify();
        $pdo = Connection::getPDO();
        $novel = (new NovelRepository($pdo))->findLatest();
        $chapters = (new ChapterRepository($pdo))->findAllBy($novel->getId());
        return $this->render('index', [
            'novel' => $novel,
            'chapters' => $chapters
        ]);
    }

    /**
     * @param array $parameters
     * @return mixed
     * @throws ForbiddenException
     * @throws NotFoundException
     * @throws ViewRenderingException
     */
    public function show(array $parameters)
    {
        Authentification::verify();
        $novel = (new NovelRepository(Connection::getPDO()))->findBy('slug', $parameters[0]);
        return $this->render('show', [
            'novel' => $novel
        ]);
    }

    /**
     * @param array $parameters
     * @return string
     * @throws ForbiddenException
     * @throws NotFoundException
     * @throws ViewRenderingException
     * @throws RouteNotFoundException
     */
    public function edit(array $parameters)
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
            return $this->render('show', [
                'errors' => $novel->getErrors(),
                'novel' => (new NovelRepository($pdo))->findBy('id', $parameters[1])
            ]);
        }
        (new NovelRepository($pdo))->updateNovel($novel);
        FlashMessage::success('Le roman a bien été modifier');
        Response::redirection($this->router->generateUrl('admin.novel.show',
            ['slug' => $novel->getSlug(), 'id' => $novel->getId()]));
    }
}
