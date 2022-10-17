<?php

/** @var Crm\Route\Route $route */

$route->namespace('post', function () use ($route){
    $route->get('', function (){
        echo 'Строка из маршрута';
    });


    // вызов контролера с параметрами внутри которого подключается модуль (обычный модуль)
//    $route->get('{two:[a-z0-9]+}/{name:[a-z0-9]+}', [\App\Admin\Controllers\Controller::class, 'index']);

});

