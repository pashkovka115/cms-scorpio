<?php

namespace Crm\Route;


class Route
{
    private static $instance = null;
    private $path = '';
    private $params = '';
    private array $routes = [];
    private $namespace;
    private array $tmpRoute = [];
//    private static $num = 0;


    private function __construct()
    {
    }


    public static function getInstance()
    {
        if (is_null(self::$instance)){
            self::$instance = new self();
        }

        return self::$instance;
    }

// namespace
    public function dispatch()
    {
        $split = explode('?', trim($_SERVER['REQUEST_URI'], '/'));
        if (isset($split[0])){
            $this->path = $split[0];
            $parts = explode('/', $split[0]);
            if (isset($parts[0])){
                $this->namespace = $parts[0];
            }
        }
        if (!$this->namespace){
            $this->namespace = '/';
        }
        if (isset($split[1])){
            $this->params = $split[1];
        }

        require $_SERVER['DOCUMENT_ROOT'] . '/routes/__.php';

        /*if (isset($this->routes[$this->namespace])){

        }*/


    }


    public function namespace(string $string, callable $func)
    {
        $this->tmpRoute[] = trim($string, '/ ');
        $func();
        array_pop($this->tmpRoute);
    }


    public function post($route, $action)
    {
        $this->route('GET', $route, $action);
    }


    public function get($route, $action)
    {
        $this->route('GET', $route, $action);
    }


    public function any(array $methods, $route, $action)
    {
        $this->route($methods, $route, $action);
    }


    public function route($method, $route, $action)
    {
        if (is_string($method)){
            $this->routes[strtoupper($method)][implode('/', $this->tmpRoute) . '/' . $route] = $action;
        }elseif (is_array($method)){
            foreach ($method as $item){
                $this->routes[strtoupper($item)][implode('/', $this->tmpRoute) . '/' . $route] = $action;
            }
        }
    }


    // todo: будет вызывать действие для роутера
    /**
     * @param callable|array $action - функция или масив [class, 'method']
     * @param array $params - масив параметров
     */
    protected function executeAction($action, array $params = [])
    {
        if (is_callable($action)){
            $action(...$params);
        }elseif (is_array($action) and count($action) == 2){
            call_user_func_array($action, $params);
        }
    }


    /**
     * @return string
     * Текущее пространство имён
     */
    public function getNamespace()
    {
        return $this->namespace;
    }


    public function getRoutes()
    {
        return $this->routes;
    }
}