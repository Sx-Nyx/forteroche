<?php

namespace Framework\Rendering;

use Framework\Rendering\Exception\ViewRenderingException;

class Renderer
{
    /**
     * @var string
     */
    private $layoutPath;

    /**
     * Renderer constructor.
     * @param string $layoutPath
     * @throws ViewRenderingException
     */
    public function __construct(string $layoutPath)
    {
        if (!file_exists($layoutPath)) {
            throw new ViewRenderingException('Unable to load the layout, the file does not exist');
        }
        $this->layoutPath = $layoutPath;
    }

    /**
     * @param string $viewPath
     * @param array $vars
     * @return string
     * @throws ViewRenderingException
     */
    public function render(string $viewPath, array $vars = []):string
    {
        if (!file_exists($viewPath)) {
            throw new ViewRenderingException('Unable to load the view, the file does not exist');
        }

        if (!empty($vars)) {
            extract($vars);
        }
        ob_start();
            require $viewPath;
        $content = ob_get_clean();

        ob_start();
            require $this->layoutPath;
        return ob_end_flush();
    }
}
