<?php
namespace Application;

class RouteTable
{
    private $table = [];

    protected $requestPath;
    protected $requestQuery;

    public function __contruct()
    {
        $this->requestPath = $_SERVER['REQUEST_URI'];
        
        if ($pathEnd = strpos($this->requestPath, '?')) {
            $this->requestPath = substr($_SERVER['REQUEST_URI'], 0, $pathEnd);
        }

        if (empty($this->requestPath)) {
            $this->requestPath = '/';
        }

        //$this->requestQuery = $_GET;
    }

    public function get($route, $callable)
    {
        $this->table['GET'][$route] = $callable;

        return $this;
    }

    public function post($route, $callable)
    {
        $this->table['POST'][$route] = $callable;

        return $this;
    }

    public function resolve()
    {
        $match = null;
        $method = $_SERVER['REQUEST_METHOD'];

        foreach ($this->table[$method] as $key => $callable) {
            if (preg_match($key, $this->requestPath) === 1) {
                call_user_func($callable);
                exit();
            }
        }
    }
}
