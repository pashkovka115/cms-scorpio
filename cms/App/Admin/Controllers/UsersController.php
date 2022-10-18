<?php


namespace App\Admin\Controllers;


use App\Modules\Scorpio\Admin\Users\Index as User;
use Crm\Modules;

class UsersController extends Controller
{
    public function index()
    {
        $module_template = Modules::includeModule(User::class, ['action' => 'index']);

        echo $this->view->template('users.index', ['module_template' => $module_template]);
    }

    /**
     * Показать форму для создания нового ресурса.
     */
    public function create()
    {
        $module_template = Modules::includeModule(User::class, ['action' => 'create']);

        echo $this->view->template('users.create', ['module_template' => $module_template]);
    }

    /**
     * Сохраните вновь созданный ресурс в хранилище.
     */
    public function store($request)
    {
        Modules::includeModule(User::class, ['action' => 'store', 'request' => $request]);
    }

    /**
     * Показать форму редактирования указанного ресурса.
     */
    public function edit($id)
    {
        $module_template = Modules::includeModule(User::class, ['id' => $id, 'action' => 'edit']);

        echo $this->view->template('users.edit', ['module_template' => $module_template]);
    }

    /**
     * Обновить указанный ресурс в хранилище.
     */
    public function update($id, $request)
    {
        Modules::includeModule(User::class, ['action' => 'update', 'id' => $id, 'request' => $request]);
    }

    /**
     * Удалить указанный ресурс из хранилища.
     */
    public function destroy($id)
    {
        Modules::includeModule(User::class, ['action' => 'destroy', 'id' => $id]);
    }
}