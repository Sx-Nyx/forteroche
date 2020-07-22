<?php

namespace Framework\Controller;

use Framework\Routing\Exception\RouteNotFoundException;
use Framework\Routing\Router;
use Framework\Security\Authentification;
use Framework\Security\Exception\ForbiddenException;
use Framework\Server\Response;
use Framework\Session\FlashMessage;

abstract class AbstractAdminController extends AbstractController
{
    /**
     * @var string $viewBasePath
     */
    protected $viewBasePath;

    /**
     * @var string $layoutPath
     */
    protected $layoutPath = 'templates/admin/base.php';

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
     * @throws RouteNotFoundException
     */
    public function authSecurity()
    {
        try {
            Authentification::verify();
        } catch (ForbiddenException $exception) {
            FlashMessage::error('Vous devez être connecté(e) pour accéder à cette page.');
            Response::redirection($this->router->generateUrl('login'));
        }
    }
}
