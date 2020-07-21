<?php

namespace App\Controller;

use App\Repository\NovelRepository;
use Framework\Controller\AbstractController;
use Framework\Database\Connection;
use Framework\Rendering\Exception\ViewRenderingException;
use Framework\Routing\Router;

class HomeController extends AbstractController
{
    /**
     * @var string $viewBasePath
     */
    protected $viewBasePath = 'templates/home/';

    public function __construct(Router $router)
    {
        parent::__construct($router);
    }

    /**
     * @return string
     * @throws ViewRenderingException
     */
    public function index(): string
    {
        $novel = (new NovelRepository(Connection::getPDO()))->findLatest();
        return $this->render('index', [
            'novel' => $novel,
            'novelSlug' => $novel->getSlug(),
        ]);
    }
}
