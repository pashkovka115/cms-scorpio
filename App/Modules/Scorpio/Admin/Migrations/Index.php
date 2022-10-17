<?php

namespace App\Modules\Scorpio\Admin\Migrations;

use Crm\Views\View;

/**
 * Class Index
 * @package App\Modules\Scorpio\Admin\Migrations
 * Модуль работы с миграциями
 */
class Index
{
    public function __construct()
    {
//        View::setPathLayouts($_SERVER['DOCUMENT_ROOT'] . '/App/Admin/Views/layouts');
        View::setPath($_SERVER['DOCUMENT_ROOT'] . '/App/Modules/Scorpio/Admin/Migrations/templates');
    }


    public function start()
    {
        return View::template('default');
    }
}
