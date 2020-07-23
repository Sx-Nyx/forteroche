<?php

namespace App\Controller\Admin;

use App\Entity\Novel;
use App\Repository\ChapterRepository;
use App\Repository\NovelRepository;
use Framework\Controller\AbstractAdminController;
use Framework\Database\Connection;
use Framework\Helper\Form;
use Framework\Rendering\Exception\ViewRenderingException;
use Framework\Routing\Exception\RouteNotFoundException;
use Framework\Routing\Router;
use Framework\Server\Response;
use Framework\Session\FlashMessage;
use Framework\Validator\Validator;

class NovelController extends AbstractAdminController
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
     * @throws RouteNotFoundException
     * @throws ViewRenderingException
     */
    public function index()
    {
        $this->authSecurity();
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
     * @throws RouteNotFoundException
     * @throws ViewRenderingException
     */
    public function show(array $parameters)
    {
        $this->authSecurity();
        $pdo = Connection::getPDO();
        $novel = $this->findBy(new NovelRepository($pdo), 'slug', $parameters[0]);
        if (!empty($_POST)) {
            $data = [
                'id' => $novel->getId(),
                'slug' => $_POST['title'],
            ];
            $updatedNovel = new Novel(new Validator($_POST, $pdo));
            $this->hydrateEntity($updatedNovel, array_merge($data, $_POST), ['id', 'title', 'description', 'slug',]);
            if (empty($updatedNovel->getErrors())) {
                (new NovelRepository(Connection::getPDO()))->updateNovel($updatedNovel);
                FlashMessage::success('Le roman a bien été modifier.');
                Response::redirection($this->router->generateUrl('admin.novel.show', [
                    'slug' => $updatedNovel->getSlug(),
                    'id' => $updatedNovel->getId()
                ]));
            }
        }
        $novel = isset($updatedNovel) ? $updatedNovel : $novel;
        return $this->render('show', [
            'form' => new Form($novel)
        ]);
    }
}
