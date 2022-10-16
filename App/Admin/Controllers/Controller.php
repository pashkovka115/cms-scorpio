<?php


namespace App\Admin\Controllers;


use Crm\Views\View;

class Controller
{
    public function __construct()
    {
//        View::setPath(conf('app.default_view_path'));
    }


    public function index($two, $name)
    {
        /*echo View::template('my.test', [
            'two' => $two,
            'name' => $name
        ]);*/
        echo __METHOD__;
    }
}