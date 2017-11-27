<?php
namespace Application;

use Application\Request;

class Router
{
    protected $routes;
    protected $method;
    protected $path;
    protected $query;

    public function __construct()
    {
        $this->routes = [];
        $this->method = \strtoupper($_SERVER['REQUEST_METHOD']);

        $this->path = '/'.\ltrim(
            \rtrim($_SERVER['REQUEST_URI'], '/'), '/'
        );

        $pathEnd = \strpos($this->path, '?');

        if ($pathEnd !== false) {
            $query = \ltrim(\substr($this->path, $pathEnd), '?');
            \parse_str($query, $this->query);

            $this->path = \substr($this->path, 0, $pathEnd);
        } else {
            $this->query = [];
        }
    }

    public function get($regex, $callable)
    {
        $this->routes['GET'][$regex] = $callable;

        return $this;
    }

    public function post($regex, $callable)
    {
        $this->routes['POST'][$regex] = $callable;

        return $this;
    }

    public function resolve()
    {
        $match = null;
        $params = [];

        if (!empty($this->routes[$this->method])) {
            foreach ($this->routes[$this->method] as $route => $callable) {
                if (\preg_match($route, $this->path, $params) === 1) {
                    \call_user_func_array($callable, [
                        $this->path,
                        $this->query,
                        $params
                    ]);
    
                    return;
                }
            }
        }

        die('404');
    }
}
