<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use Framework\Controller\AbstractController;
use Framework\Database\Connection;
use Framework\Routing\Router;
use Framework\Server\Response;
use Framework\Session\FlashMessage;

class CommentController extends AbstractController
{
    /**
     * @var Router
     */
    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
        parent::__construct($router);
    }

    public function report(array $parameters)
    {
        (new CommentRepository(Connection::getPDO()))->report($parameters[2]);
        FlashMessage::success('Le commentaire a bien été signalé.');
        Response::redirection($this->router->generateUrl('novel.show',
            ['novelSlug' => $parameters[0], 'chapterSlug' => $parameters[1]]));
    }
}
