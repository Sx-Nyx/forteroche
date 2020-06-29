<?php

namespace Framework\Routing;

use Framework\Routing\Exception\RouteNotFoundException;

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
    public function __call($method, $args = []): self
    {
        if (in_array(strtoupper($method), $this->methods)) {
            $name = !empty($args[2]) ? $args[2] : null;
            $this->registerRoute(strtoupper($method), $args[0], $args[1], $name);
            return $this;
        }
        throw new \BadMethodCallException("Invalid method \"$method\".");
    }

    /**
     * @param string $routeName
     * @param array $params
     * @return string
     * @throws RouteNotFoundException
     */
    public function generateUrl(string $routeName, array $params = []): string
    {
        if (!isset($this->name[$routeName])) {
            throw new RouteNotFoundException("Route '{$routeName}' does not exist.");
        }
        $generateUrl = $this->name[$routeName]->path;
        foreach ($params as $key => $value) {
            if (array_key_exists($key, $params)) {
                $generateUrl = $this->str_replace_first($this->name[$routeName]->parameters[':' . $key], $value, $generateUrl);
            }
        }
        return $generateUrl;
    }

    /**
     * @return string
     */
    public function listen()
    {
        foreach ($this->routes[$this->getRequestMethod()] as $route) {
            if ($route->routeMatch($this->getRequestUri())) {
                return $route->dispatch($this);
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
    private function registerRoute(string $method, string $path, $callable, ?string $name): Route
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
    private function generate404(): string
    {
        http_response_code(404);
        include $this->notFound;
        die();
    }

    private function str_replace_first(string $from, string $to, string $content): string
    {
        $from = '/' . preg_quote($from, '/') . '/';
        return preg_replace($from, $to, $content, 1);
    }

}
