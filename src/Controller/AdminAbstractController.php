<?php

namespace Framework\Controller;

use Framework\Routing\Router;

class AdminAbstractController extends AbstractController
{
    /**
     * @var string $viewBasePath
     */
    protected $viewBasePath;

    /**
     * @var string $layoutPath
     */
    protected $layoutPath = 'templates/admin/base.php';

    public function __construct(Router $router)
    {
        parent::__construct($router);
    }
}
