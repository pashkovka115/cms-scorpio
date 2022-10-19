<?php

use Crm\Route\Route;



$route = Route::getInstance();




$file_name = base_path() . '/routes/' . $route->getNamespace() . '.php';

if (file_exists($file_name)){
    require $file_name;
}

