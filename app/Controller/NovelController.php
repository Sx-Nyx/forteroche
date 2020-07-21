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

   public function __construct(Router $router)
   {
       parent::__construct($router);
   }

    /**
     * @param array $parameters
     * @return string
     * @throws NotFoundException
     * @throws ViewRenderingException
     */
    public function index(array $parameters): string
    {
        $pdo = Connection::getPDO();

        $novel = (new NovelRepository($pdo))->findBy('slug', $parameters[0]);
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
     * @throws NotFoundException
     * @throws ViewRenderingException
     */
    public function show(array $parameters): string
    {
        $chapter = (new ChapterRepository(Connection::getPDO()))->findWithComment($parameters[1]);
        return $this->render('show', [
            'novelSlug' => $parameters[0],
            'chapterSlug' => $parameters[1],
            'chapter' => $chapter,
        ]);
    }
}
