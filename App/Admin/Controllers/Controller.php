<?php


namespace App\Admin\Controllers;


use Crm\Views\View;

class Controller
{
    protected View $view;


    public function __construct()
    {
        $this->view = new View();
        $this->view->setPath($_SERVER['DOCUMENT_ROOT'] . '/App/Admin/Views/scorpio');
        $this->view->setPathLayouts($_SERVER['DOCUMENT_ROOT'] . '/App/Admin/Views/scorpio/layouts');

//        View::setPath($_SERVER['DOCUMENT_ROOT'] . '/App/Admin/Views/scorpio');
//        View::setPathLayouts($_SERVER['DOCUMENT_ROOT'] . '/App/Admin/Views/scorpio/layouts');
    }
}