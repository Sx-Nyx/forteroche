<?php

namespace App\Controller\Admin;

use App\Repository\UserRepository;
use Framework\Controller\AbstractAdminController;
use Framework\Database\Connection;
use Framework\Routing\Router;
use Framework\Server\Response;
use Framework\Session\FlashMessage;
use Framework\Session\Session;

class UserController extends AbstractAdminController
{
    /**
     * @var Router
     */
    private $router;

    /**
     * @var string $viewBasePath
     */
    protected $viewBasePath = 'templates/admin/user/';

    public function __construct(Router $router)
    {
        parent::__construct($router);
        $this->router = $router;
    }

    public function index(array $error = [])
    {
        $this->authSecurity();
        return $this->render('index', [
            'error' => $error
        ]);
    }

    public function modify()
    {
        $this->authSecurity();
        $repository = new UserRepository(Connection::getPDO());
        $user = $this->findBy($repository, 'id', Session::get('auth'));
        if (password_verify($_POST['password'], $user->getPassword()) === false) {
            $error['password'] = 'Mot de passe incorect.';
            $this->index($error);
        } elseif ($_POST['new_password'] !== $_POST['new_password_confirm']) {
            $error['password_confirm'] = 'Les mots de passe ne correspondent pas.';
            $this->index($error);
        } else {
            $user->setPassword(password_hash($_POST['new_password'], PASSWORD_BCRYPT));
            $repository->updateUser($user);
            FlashMessage::success('Le mot de passe a bien été modifié.');
            Response::redirection($this->router->generateUrl('user.index'));
        }
    }
}
