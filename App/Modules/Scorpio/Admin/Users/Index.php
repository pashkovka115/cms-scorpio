<?php

namespace App\Modules\Scorpio\Admin\Users;

use Crm\Route\Route;
use Crm\Views\View;
use App\Modules\Scorpio\Admin\Users\Models\User;

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
        }elseif (isset($params['action']) and $params['action'] == 'store') {
            if (isset($params['request'])){
                $this->store($params['request']);
            }else{
                throw new \Exception('Не передан "request" ' . __METHOD__);
            }
        }

        return '';
    }


    protected function store($request)
    {
        $user = new User($request, ['save']);
        $user->save();

        redirect(Route::getInstance()->name('scorpio.users.create'));
    }


    protected function create()
    {
        return $this->view->template('create');
    }


    /**
     * @param Route $route
     * @param $controller
     * Маршруты для модуля
     */
    public static function getRoutes(Route $route, $controller)
    {
        $route->namespace('users', function () use ($route, $controller){
            $route->get('create', [$controller, 'create'], 'scorpio.users.create');
            $route->post('store', [$controller, 'store'], 'scorpio.users.store');
        });
    }
}
