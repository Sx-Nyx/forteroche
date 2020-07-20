<?php

namespace App\Controller;

use App\Repository\NovelRepository;
use App\Repository\UserRepository;
use Framework\Database\Connection;
use Framework\Database\Exception\NotFoundException;
use Framework\Rendering\Renderer;
use Framework\Routing\Router;
use Framework\Security\Authentification;
use Framework\Server\Response;
use Framework\Session\Session;

class LoginController
{
    public static function index(Router $router, array $error = [])
    {
        $novel = (new NovelRepository(Connection::getPDO()))->findLatest();
        $renderer = new Renderer("../templates/base.php");
        $renderer->render("../templates/login/index.php", [
            'novelSlug' => $novel->getSlug(),
            'router' => $router,
            'error' => $error
        ]);
    }

    public static function login(Router $router)
    {
        $error['credentials'] = 'Identifiant ou mot de passe incorrect';
        if (!empty($_POST['username']) && !empty($_POST['password'])) {
            $repository = new UserRepository(Connection::getPDO());
            try {
                $user = $repository->findBy('username', $_POST['username']);
                if (password_verify($_POST['password'], $user->getPassword()) === true) {
                    Session::set('auth', $user->getId());
                    Response::redirection($router->generateUrl('admin.novel'));
                }
            } catch (NotFoundException $e) {
                self::index($router, $error);
            }
        }
    }

    public static function logout()
    {
        Authentification::verify();
        Session::delete('auth');
        Response::redirection('login');
    }
}
