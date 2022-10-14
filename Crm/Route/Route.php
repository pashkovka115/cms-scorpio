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

        /**
         * Определение маршрутов
         */
        require $_SERVER['DOCUMENT_ROOT'] . '/routes/__.php';

        echo '<pre>'; print_r($this->getRoutes()); echo '</pre>';

        if (isset($this->routes[$_SERVER['REQUEST_METHOD']])){
            foreach ($this->routes[$_SERVER['REQUEST_METHOD']] as $route){
                if (is_array($route)){
                    $pattern = trim(array_key_first($route['route']), '/');
//                    var_dump($pattern, $this->path); die();
                    if (preg_match('#'.$pattern.'#', $this->path, $matches)){
                        $action = $route['route'][array_key_first($route['route'])];
                        $this->executeAction($action);
                        break;
                    }
                }
            }
        }
    }


    public function namespace(string $string, callable $func)
    {
        $this->tmpRoute[] = trim($string, '/ ');
        $func();
        array_pop($this->tmpRoute);
    }


    public function post($route, $action, string $name = '')
    {
        $this->route('GET', $route, $action, $name);
    }


    public function get($route, $action, string $name = '')
    {
        $this->route('GET', $route, $action, $name);
    }


    public function any(array $methods, $route, $action, string $name = '')
    {
        $this->route($methods, $route, $action, $name);
    }


    public function route($method, $route, $action, string $name = '')
    {
        $route = trim($route, '/ ');
        if (is_string($method)){
            $method = strtoupper($method);
            $this->routes[$method][] = [
                'route' => [implode('/', $this->tmpRoute) . '/' . $route => $action],
                'name' => $name
            ];

        }elseif (is_array($method)){
            foreach ($method as $item){
                $item = strtoupper($item);
                $this->routes[$item][] = [
                    'route' => [implode('/', $this->tmpRoute) . '/' . $route => $action],
                    'name' => strtolower($item) . '.' .$name
                ];
            }
        }
    }


    /**
     * @param string $name
     * @return false|int|string|null
     * Возвращает ссылку по имени маршрута
     * todo: доделать для параметров
     */
    public function name(string $name)
    {
        foreach ($this->routes as $methods){
            if (is_array($methods)){
                foreach ($methods as $route){
                    if ($route['name'] == $name){
                        return array_key_first($route['route']);
                    }
                }
            }

        }

        return false;
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
        }else{
            throw new \Exception('Не корректный метод вызова действия в маршруте');
        }
    }


    /**
     * @return string
     * Текущее пространство имён для URL
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