<?php


namespace App\Admin\Controllers;


use Crm\Views\View;

class Controller
{
    protected View $view;


    public function __construct()
    {
        $this->view = new View();
        $this->view->setPath(base_path() . '/App/Admin/Views/scorpio');
        $this->view->setPathLayouts(base_path() . '/App/Admin/Views/scorpio/layouts');
    }
}