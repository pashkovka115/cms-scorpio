<?php


namespace App\Http\Controllers;


class Controller
{
    public function index($two, $name)
    {
        echo __METHOD__;
//        var_dump(func_get_args(), $two, $name);
    }
}