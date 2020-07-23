<?php

namespace App\Controller\Admin;

use App\Repository\CommentRepository;
use Framework\Controller\AbstractAdminController;
use Framework\Database\Connection;
use Framework\Rendering\Exception\ViewRenderingException;
use Framework\Routing\Exception\RouteNotFoundException;
use Framework\Routing\Router;
use Framework\Server\Response;

class CommentController extends AbstractAdminController
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
     * @throws RouteNotFoundException
     */
    public function index()
    {
        $this->authSecurity();
        $repository = new CommentRepository(Connection::getPDO());
        if ($repository->countReported() > 0) {
            $comments = $repository->findAllReported();
            return $this->render('index', [
                'comments'     => $comments,
            ]);
        }
        Response::redirection($this->router->generateUrl('admin.novel'));
    }

    /**
     * @param array $parameters
     * @return string
     * @throws RouteNotFoundException
     * @throws ViewRenderingException
     */
    public function show(array $parameters)
    {
        $this->authSecurity();
        $comment = $this->findBy(new CommentRepository(Connection::getPDO()), 'id', $parameters[0]);
        return $this->render('show', [
            'comment'     => $comment,
        ]);
    }

    /**
     * @param array $parameters
     * @throws RouteNotFoundException
     */
    public function edit(array $parameters)
    {
        $this->authSecurity();
        $repository = new CommentRepository(Connection::getPDO());
        $comment = $this->findBy($repository, 'id', $parameters[0]);
        $comment->setReported(-1);
        $repository->updateComment($comment);
        Response::redirection($this->router->generateUrl('admin.novel'));
    }

    /**
     * @param array $parameters
     * @throws RouteNotFoundException
     */
    public function delete(array $parameters)
    {
        $this->authSecurity();
        (new CommentRepository(Connection::getPDO()))->delete($parameters[0]);
        Response::redirection($this->router->generateUrl('admin.novel'));

    }
}
