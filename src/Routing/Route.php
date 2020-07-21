<?php

namespace Framework\Routing;

use Framework\Routing\Exception\RouteCallbackException;

class Route
{
    /**
     * @var string
     */
    public $path;

    /**
     * @var string
     */
    private $callable;

    /**
     * @var array
     */
    public $parameters = [
        ':id'   => '([0-9]+)',
        ':slug'  => '([a-z0-9\-]+)',
        ':novelSlug'  => '([a-z0-9\-]+)',
        ':chapterSlug'  => '([a-z0-9\-]+)',
    ];

    /**
     * @var array
     */
    private $matched_parameters = [];

    public function __construct(string $path, string $callable)
    {
        $this->path = $this->validateRouteUri($path);
        $this->callable = $callable;
    }

    /**
     * @param string $uri
     * @return bool
     */
    public function routeMatch(string $uri = '')
    {
        $pattern = '#^' . $this->path . '$#iu';

        if (preg_match_all($pattern, $uri, $matches) > 0)
        {
            if (count($matches) > 1)
            {
                array_shift($matches);

                foreach ($matches as $match)
                {
                    $this->matched_parameters[] = $match[0];
                }
            }
            return true;
        }
        return false;
    }

    /**
     * @param Router $router
     * @param callable|string|null $action
     * @return mixed
     * @throws RouteCallbackException
     */
    public function dispatch(Router $router, $action = null)
    {
        $params = $this->matched_parameters;

        $action = !is_null($action) ? $action : $this->callable;

        $call       = explode('::', $action);
        $className  = $call[0];
        $methodName = $call[1];

        if (class_exists($className))
        {
            $class = new $className($router);
            if (method_exists($class, $methodName))
            {

                return $class->$methodName($params);
            }
        }

        if (is_callable($action))
        {
            return call_user_func_array($action, $params);
        }

        throw new RouteCallbackException("Unable to dispatch router action.");
    }

    /**
     * @param string $uri
     * @return string
     */
    private function validateRouteUri(string $uri):string
    {
        $uri = trim($uri, '/');
        $uri = str_replace([
            '.',
            '?',
            '&',
        ], [
            '\.',
            '\?',
            '\&',
        ], $uri);

        while ($this->routeHasBindings($uri) === true)
        {
            foreach ($this->parameters as $key => $pattern)
            {
                $uri = preg_replace("/$key/iu", $pattern, $uri);
            }
        }
        return $uri;
    }

    /**
     * @param $uri
     * @return bool
     */
    private function routeHasBindings($uri):bool
    {
        return preg_match('#:([\w]+)#', $uri) >= 1;
    }
}
