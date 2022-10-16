<?php

use Crm\Route\Route;



$route = Route::getInstance();
$file_name = $_SERVER['DOCUMENT_ROOT'] . '/routes/' . $route->getNamespace() . '.php';

if (file_exists($file_name)){
    require $file_name;
}

