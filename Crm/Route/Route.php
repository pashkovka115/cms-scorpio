<?php

namespace Crm\Route;


class Route
{
    /** @var null $instance экземпляр Route */
    private static $instance = null;

    /** @var string $path URL без параметров */
    private $path = '';

    /** @var string $params параметры из URL */
    private $params = '';

    /** @var array $routes маршруты */
    private array $routes = [];

    /** @var string $namespace первый сегмент URL используется как пространство имён в маршрутах */
    private $namespace;

    /** @var array $tmpRoute временное хранилище для сборки маршрута */
    private array $tmpRoute = [];


    private function __construct()
    {
    }


    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }


    /**
     * @throws \Exception
     * Диспетчер маршрутов
     */
    public function dispatch()
    {
        $split = explode('?', trim($_SERVER['REQUEST_URI'], '/'));
        if (isset($split[0])) {
            $this->path = $split[0];
            $parts = explode('/', $split[0]);
            if (isset($parts[0])) {
                $this->namespace = $parts[0];
            }
        }
        if (!$this->namespace) {
            $this->namespace = '/';
        }
        if (isset($split[1])) {
            $this->params = $split[1];
        }

        /**
         * Определение маршрутов
         */
        require $_SERVER['DOCUMENT_ROOT'] . '/routes/__.php';

        if (isset($this->routes[$_SERVER['REQUEST_METHOD']])) {
            foreach ($this->routes[$_SERVER['REQUEST_METHOD']] as $route) {
                if (is_array($route)) {
                    $pattern = $this->getPattern($route['route']);

                    if (preg_match('#^' . $pattern . '$#', $this->path, $matches)) {
                        $params = [];
                        foreach ($matches as $key => $match) {
                            if (is_string($key)) {
                                $params[$key] = $match;
                            }
                        }
                        $action = $route['route'][array_key_first($route['route'])];
                        $this->executeAction($action, $params);
                        break;
                    }
                }
            }
        }
    }


    /**
     * @param $route
     * @return array|string|string[]|null
     * Получение шаблона поиска для диспетчера
     */
    private function getPattern($route)
    {
        $pattern = trim(array_key_first($route), '/');
        $pattern = preg_replace_callback('#\{.+?\}#', function ($matches) {
            $split = explode(':', trim($matches[0], '{}'));
            return '(?P<' . $split[0] . '>' . $split[1] . ')';
        }, $pattern);

        return $pattern;
    }


    /**
     * @param callable|array $action - функция или масив [class, 'method']
     * @param array $params - масив параметров
     */
    protected function executeAction($action, array $params = [])
    {
        if (is_array($action) and count($action) == 2) {
            $class = $action[0];
            $method = $action[1];
            call_user_func_array([(new $class), $method], $params);
        } elseif (is_callable($action)) {
            call_user_func_array($action, $params);
        } else {
            throw new \Exception('Не корректный метод вызова действия в маршруте');
        }
    }


    public function namespace(string $string, callable $func)
    {
        $this->tmpRoute[] = trim($string, '/ ');
        $func();
        array_pop($this->tmpRoute);
    }


    /**
     * @param $route
     * @param $action
     * @param string $name
     * Установить маршрут методом POST
     */
    public function post($route, $action, string $name = '')
    {
        $this->route('GET', $route, $action, $name);
    }


    /**
     * @param $route
     * @param $action
     * @param string $name
     * Установить маршрут методом GET
     */
    public function get($route, $action, string $name = '')
    {
        $this->route('GET', $route, $action, $name);
    }


    /**
     * @param array $methods
     * @param $route
     * @param $action
     * @param string $name
     * Установить маршрут для нескольких методов
     */
    public function any(array $methods, $route, $action, string $name = '')
    {
        $this->route($methods, $route, $action, $name);
    }


    /**
     * @param $method
     * @param $route
     * @param $action
     * @param string $name
     * Установить маршрут
     */
    public function route($method, $route, $action, string $name = '')
    {
        $route = trim($route, '/ ');
        if (is_string($method)) {
            $method = strtoupper($method);
            $this->routes[$method][] = [
                'route' => [implode('/', $this->tmpRoute) . '/' . $route => $action],
                'name' => $name
            ];

        } elseif (is_array($method)) {
            foreach ($method as $item) {
                $item = strtoupper($item);
                $this->routes[$item][] = [
                    'route' => [implode('/', $this->tmpRoute) . '/' . $route => $action],
                    'name' => strtolower($item) . '.' . $name
                ];
            }
        }
    }


    /**
     * @param string $name - имя маршрута ссылку на который надо вывести
     * @param array $search - вырезать эти символы из результата
     * @return false|int|string|null
     * Возвращает ссылку по имени маршрута
     */
    public function name(string $name, array $params = [], array $search = [])
    {
        foreach ($this->routes as $methods) {
            if (is_array($methods)) {
                foreach ($methods as $route) {
                    if ($route['name'] == $name) {
                        $url_pattern = array_key_first($route['route']);
                        foreach ($params as $param => $value) {
                            $url_pattern = preg_replace_callback(
                                '#\{' . $param . '\:.+?\}#',
                                function ($matches) use ($value) {
                                    return $value;
                                },
                                $url_pattern
                            );
                        }

                        if ($search){
                            return str_replace($search, '', $url_pattern);
                        }
                        return $url_pattern;
                    }
                }
            }
        }

        return false;
    }


    /**
     * @return string
     * Текущее пространство имён для URL
     */
    public function getNamespace()
    {
        return $this->namespace;
    }


    /**
     * @return array
     * Возвращает масив маршрутов
     */
    public function getRoutes()
    {
        return $this->routes;
    }


    /**
     * @return false|string[]
     * GET параметры
     */
    public function getParams()
    {
        if ($this->params){
            return explode('&', $this->params);
        }

        return false;
    }
}