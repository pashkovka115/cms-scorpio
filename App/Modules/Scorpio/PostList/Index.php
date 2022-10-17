<?php

namespace App\Modules\Scorpio\PostList;

use Crm\Views\View;

class Index
{
    public function __construct()
    {
        View::setPath($_SERVER['DOCUMENT_ROOT'] . '/App/Modules/Scorpio/PostList/templates');
    }


    public function start()
    {
        return View::template('default');

        /*return View::template('default', [
            'two' => 2,
            'name' => 'Vasya'
        ]);*/
    }
}