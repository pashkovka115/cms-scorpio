<?php

namespace App\Modules\Scorpio\Admin\Users;

use App\Models\User;
use Crm\Route\Request;
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

        $this->view->setPath(base_path() . '/App/Modules/Scorpio/Admin/Users/templates');
    }


    /**
     * @param array $params ['action' => create|update|delete|...]
     * @return false|string
     */
    public function start(array $params)
    {
        if (isset($params['action'])) {
            switch ($params['action']) {
                case 'index':
                    return $this->index();

                case 'create':
                    return $this->create();

                case 'store':
                    if (isset($params['request'])) {
                        $this->store($params['request']);
                    } else {
                        throw new \Exception('Не передан "request" ' . __METHOD__);
                    }
                    break;

                case 'edit':
                    if (isset($params['id'])){
                        return $this->edit($params['id']);
                    }else{
                        throw new \Exception('Не передан "id"' . __METHOD__);
                    }

                case 'update':
                    if (isset($params['id'])){
                        $this->update($params['id'], $params['request']);
                    }else{
                        throw new \Exception('Не передан "id"' . __METHOD__);
                    }
                    break;

                case 'destroy':
                    if (isset($params['id'])){
                        $this->destroy($params['id']);
                    }else{
                        throw new \Exception('Не передан "id"' . __METHOD__);
                    }
                    break;

                default:
                    throw new \Exception('Не определено действие ' . __METHOD__);
            }
        }else {
            throw new \Exception('Не передан "action" ' . __METHOD__);
        }
    }


    public function destroy($id)
    {
        User::destroy($id);

        redirect(Route::getInstance()->name('scorpio.users.index'));
    }


    public function update($id, Request $request)
    {
        User::update($id, $request->toArray(['save', 'applay']));

        if ($request->hasInput('save')){
            redirect(Route::getInstance()->name('scorpio.users.index'));
        }

        redirect(Route::getInstance()->name('scorpio.users.edit', ['id' => $id]));
    }


    public function edit($id)
    {
        $user = User::find($id);

        return $this->view->template('edit', ['user' => $user, 'id' => $id]);
    }


    protected function index()
    {
        $users = User::all();

        return $this->view->template('index', ['users' => $users]);
    }


    protected function store(Request $request)
    {
        $user = new User($request->toArray(), ['save', 'applay']);
        $id = $user->save();
        if ($request->hasInput('save')){
            redirect(Route::getInstance()->name('scorpio.users.index'));
        }
        redirect(Route::getInstance()->name('scorpio.users.edit', ['id' => $id]));
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
        $route->namespace('users', function () use ($route, $controller) {
            $route->get('', [$controller, 'index'], 'scorpio.users.index');
            $route->get('create', [$controller, 'create'], 'scorpio.users.create');
            $route->post('store', [$controller, 'store'], 'scorpio.users.store');
            $route->get('edit/{id:[0-9]+}', [$controller, 'edit'], 'scorpio.users.edit');
            $route->post('update/{id:[0-9]+}', [$controller, 'update'], 'scorpio.users.update');
            $route->get('destroy/{id:[0-9]+}', [$controller, 'destroy'], 'scorpio.users.destroy');
        });
    }
}
