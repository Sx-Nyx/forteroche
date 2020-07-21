<?php

namespace App\Controller\Admin;

use App\Repository\CommentRepository;
use Framework\Controller\AdminAbstractController;
use Framework\Database\Connection;
use Framework\Database\Exception\NotFoundException;
use Framework\Rendering\Exception\ViewRenderingException;
use Framework\Routing\Router;
use Framework\Security\Authentification;
use Framework\Security\Exception\ForbiddenException;
use Framework\Server\Response;

class CommentController extends AdminAbstractController
{
    /**
     * @var string $viewBasePath
     */
    protected $viewBasePath = 'templates/admin/comment/';

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
        $comments = (new CommentRepository(Connection::getPDO()))->findAllReported();
        return $this->render('index', [
            'comments'     => $comments,
        ]);
    }

    /**
     * @param array $parameters
     * @return string
     * @throws ForbiddenException
     * @throws ViewRenderingException
     * @throws NotFoundException
     */
    public function show(array $parameters)
    {
        Authentification::verify();
        $comment = (new CommentRepository(Connection::getPDO()))->findBy('id', $parameters[0]);
        return $this->render('show', [
            'comment'     => $comment,
        ]);
    }

    public function edit(array $parameters)
    {
        Authentification::verify();
        $comment = (new CommentRepository(Connection::getPDO()))->findBy('id', $parameters[0]);
        $comment->setReported(-1);
        (new CommentRepository(Connection::getPDO()))->updateComment($comment);
        Response::redirection($this->router->generateUrl('admin.novel'));
    }

    public function delete(array $parameters)
    {
        Authentification::verify();
        (new CommentRepository(Connection::getPDO()))->delete($parameters[0]);
        Response::redirection($this->router->generateUrl('admin.novel'));

    }
}
