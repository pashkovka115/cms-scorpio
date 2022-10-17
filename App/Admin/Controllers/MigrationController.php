<?php


namespace App\Admin\Controllers;


use App\Modules\Scorpio\PostList\Index;
use Crm\Modules;
use Crm\Views\View;

class MigrationController extends Controller
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
        Modules::includeModule(\App\Modules\Scorpio\Admin\Migrations\Index::class, ['action' => 'create']);
    }

    /**
     * Сохраните вновь созданный ресурс в хранилище.
     */
    public function store($request)
    {
        //
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