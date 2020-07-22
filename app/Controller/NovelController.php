<?php

namespace App\Controller;

use App\Repository\ChapterRepository;
use App\Repository\NovelRepository;
use Framework\Controller\AbstractController;
use Framework\Database\Connection;
use Framework\Database\Exception\NotFoundException;
use Framework\Rendering\Exception\ViewRenderingException;
use Framework\Routing\Router;

class NovelController extends AbstractController
{
    /**
     * @var string $viewBasePath
     */
    protected $viewBasePath = 'templates/novel/';

    /**
     * @var Router
     */
    private $router;

    public function __construct(Router $router)
   {
       parent::__construct($router);
       $this->router = $router;
   }

    /**
     * @param array $parameters
     * @return string
     * @throws ViewRenderingException
     */
    public function index(array $parameters): string
    {
        $pdo = Connection::getPDO();
        $novel = $this->findBy(new NovelRepository($pdo), 'slug', $parameters[0]);
        $chapters = (new ChapterRepository($pdo))->findAndCount($novel->getId());
        return $this->render('index', [
            'novel' => $novel,
            'novelSlug' => $novel->getSlug(),
            'chapters' => $chapters
        ]);
    }

    /**
     * @param array $parameters
     * @return string
     * @throws ViewRenderingException
     */
    public function show(array $parameters): string
    {
        try {
            $chapter = (new ChapterRepository(Connection::getPDO()))->findWithComment($parameters[1]);
        } catch (NotFoundException $exception) {
            $this->router->generate404();
        }
        return $this->render('show', [
            'novelSlug' => $parameters[0],
            'chapterSlug' => $parameters[1],
            'chapter' => $chapter,
        ]);
    }
}
