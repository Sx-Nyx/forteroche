<?php

namespace Framework\Routing;

class Router
{
    /**
     * @var string
     */
    private $notFound;

    /**
     * @var array
     */
    private $methods = [
        'GET',
        'POST'
    ];

    /**
     * @var Route[]
     */
    private $routes = [];

    /**
     * @var array
     */
    private $name = [];

    public function __construct(string $notFound)
    {
        $this->notFound = $notFound;
    }

    /**
     * @param $method
     * @param array $args
     *      $args = [
     *          'path'      =>  (string)
     *          'callable'  =>  (string)
     *          'name'      =>  (string|null)
     *      ]
     * @return $this
     */
    public function __call($method, $args = []):self
    {
        if (in_array(strtoupper($method), $this->methods)) {
            $name = !empty($args[2]) ? $args[2] : null;
            $this->registerRoute(strtoupper($method), $args[0], $args[1], $name);
            return $this;
        }
        throw new \BadMethodCallException("Invalid method \"$method\".");
    }

    /**
     * @return string
     */
    public function listen()
    {
        foreach ($this->routes[$this->getRequestMethod()] as $route) {
            if ($route->routeMatch($this->getRequestUri())) {
                return $route->dispatch();
            }
        }
        return $this->generate404();
    }

    /**
     * @param string $method
     * @param string $path
     * @param string $callable
     * @param string|null $name
     * @return Route
     */
    private function registerRoute(string $method, string $path, string $callable, ?string $name): Route
    {
        $route = new Route($path, $callable);
        $this->routes[$method][] = $route;
        if ($name) {
            $this->name[$name] = $route;
        }
        return $route;
    }

    /**
     * @return string
     */
    private function getRequestMethod(): string
    {
        return strtoupper($_SERVER['REQUEST_METHOD']);
    }

    /**
     * @return string
     */
    private function getRequestUri(): string
    {
        return trim($_SERVER['REQUEST_URI'], '/');
    }

    /**
     * @return string
     */
    private function generate404()
    {
        http_response_code(404);
        include $this->notFound;
        die();
    }
}