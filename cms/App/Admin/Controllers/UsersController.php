<?php


namespace App\Admin\Controllers;


use App\Modules\Scorpio\Admin\Users\Index as User;
use Crm\Modules;
use Crm\Route\Route;
use Crm\Views\View;

class UsersController extends Controller
{
    public function index($two, $name)
    {
        /*echo View::template('my.test', [
            'two' => $two,
            'name' => $name
        ]);*/

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
    {  // todo: доделать
//        d(Route::getInstance()->getRoutes());
//        dd($request);
        Modules::includeModule(User::class, ['action' => 'store', 'request' => $request]);
    }

    /**
     * Показать указанный ресурс.
     */
    public function show($id)
    {
        //
    }

    /**
     * Показать форму редактирования указанного ресурса.
     */
    public function edit($id)
    {
        //
    }

    /**
     * Обновить указанный ресурс в хранилище.
     */
    public function update($request, $id)
    {
        //
    }

    /**
     * Удалить указанный ресурс из хранилища.
     */
    public function destroy($id)
    {
        //
    }
}