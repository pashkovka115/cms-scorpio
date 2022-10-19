<?php


namespace App\Admin\Controllers;


class HomeController extends Controller
{
    public function index()
    {
        echo $this->view->template('home.index');
    }
}