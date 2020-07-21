<?php

namespace Framework\Controller;

use Framework\Rendering\Exception\ViewRenderingException;
use Framework\Rendering\Renderer;
use Framework\Routing\Router;

abstract class AbstractController
{
    /**
     * @var string $viewBasePath
     */
    protected $viewBasePath;

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
    }

    /**
     * @param string $viewPath
     * @param array $variables
     * @return string
     * @throws ViewRenderingException
     */
    public function render(string $viewPath, array $variables = []): string
    {
        $variables['router'] = $this->router;
        if (substr($viewPath, -4) !== '.php') {
            return (new Renderer($this->layoutPath))->render($this->viewBasePath . $viewPath . '.php', $variables);
        }
        return (new Renderer($this->layoutPath))->render($this->viewBasePath . $viewPath, $variables);
    }
}
