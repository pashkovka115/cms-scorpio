<?php


namespace App\Admin\Controllers;


use Crm\Views\View;

class Controller
{
    public function __construct()
    {
//        View::setPath($_SERVER['DOCUMENT_ROOT'] . '/App/Admin/Views');
        View::setPathLayouts($_SERVER['DOCUMENT_ROOT'] . '/App/Admin/Views/layouts');
    }
}