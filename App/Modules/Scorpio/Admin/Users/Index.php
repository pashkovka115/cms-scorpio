<?php

namespace App\Modules\Scorpio\Admin\Users;

use Crm\Route\Route;
use Crm\Views\View;

/**
 * Class Index
 * @package App\Modules\Scorpio\Admin\Migrations
 * Модуль работы с миграциями
 */
class Index
{
    protected View $view;


    public function __construct()
    {
        $this->view = new View();

        $this->view->setPath($_SERVER['DOCUMENT_ROOT'] . '/App/Modules/Scorpio/Admin/Users/templates');
    }


    /**
     * @param array $params ['action' => create|update|delete|...]
     * @return false|string
     */
    public function start(array $params)
    {
        if (isset($params['action']) and $params['action'] == 'create') {
            return $this->create();
        }

        return '';
    }


    protected function create()
    {
        return $this->view->template('create');
    }


    public static function getRoutes(Route $route, $controller)
    {
        $route->namespace('users', function () use ($route, $controller){
            $route->get('create', [$controller, 'create'], 'scorpio.users.create');
        });
    }
}
