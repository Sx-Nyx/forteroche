<?php

namespace App\Controller;

use App\Repository\NovelRepository;
use App\Repository\UserRepository;
use Framework\Controller\AbstractAdminController;
use Framework\Controller\AbstractController;
use Framework\Database\Connection;
use Framework\Database\Exception\NotFoundException;
use Framework\Rendering\Exception\ViewRenderingException;
use Framework\Routing\Exception\RouteNotFoundException;
use Framework\Routing\Router;
use Framework\Security\Authentification;
use Framework\Server\Response;
use Framework\Session\Session;

class LoginController extends AbstractAdminController
{
    /**
     * @var string $viewBasePath
     */
    protected $viewBasePath = 'templates/login/';

    /**
     * @var string $layoutPath
     */
    protected $layoutPath = 'templates/base.php';

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
     * @param array $error
     * @return string
     * @throws ViewRenderingException
     */
    public function index(array $error = []): string
    {
        $novel = (new NovelRepository(Connection::getPDO()))->findLatest();
        return $this->render('index', [
            'novelSlug' => $novel->getSlug(),
            'error' => $error
        ]);
    }

    /**
     * @throws ViewRenderingException
     * @throws RouteNotFoundException
     */
    public function login()
    {
        $error['credentials'] = 'Identifiant ou mot de passe incorrect';
        if (!empty($_POST['username']) && !empty($_POST['password'])) {
            $repository = new UserRepository(Connection::getPDO());
            try {
                $user = $repository->findBy('username', $_POST['username']);
                if (password_verify($_POST['password'], $user->getPassword()) === true) {
                    Session::set('auth', $user->getId());
                    Response::redirection($this->router->generateUrl('admin.novel'));
                }
            } catch (NotFoundException $e) {
                $this->index($error);
            }
        }
    }

    public function logout()
    {
        $this->authSecurity();
        Session::delete('auth');
        Response::redirection('login');
    }
}
