<?php

//use Crm\Route\Route;

//$route = Route::getInstance();

/** @var Crm\Route\Route $route */


$route->namespace('mynamespace', function () use ($route){
    $route->get('first/two/free', function (){
        echo __FILE__;
    });
});


$route->get('two/two/free', function (){
    echo __FILE__;
});



$route->namespace('mynamespace3', function () use ($route){

    $route->namespace('mynamespace33', function () use ($route){
        $route->get('first/two/free', function (){
            echo __FILE__;
        });
    });

    $route->namespace('mynamespace44', function () use ($route){
        $route->namespace('mynamespace55', function () use ($route){

            $route->get('first/two/free', function (){
                echo __FILE__;
            });

        });
    });

    $route->namespace('mynamespace77', function () use ($route){
        $route->get('first/two/free', function (){
            echo __FILE__;
        });

        $route->any(['get', 'post'], 'MY/first/two/free', function (){
            echo __FILE__;
        });

    });
});

$route->get('first/{two:[0-9]+}/free/{name:[a-z0-9]+}/', function ($two, $name){
    echo __FILE__;
    var_dump($two, $name);
}, 'route.first.2');


$route->get('first/{two:[0-9]+}/free/{name:[a-z0-9]+}/', [\App\Http\Controllers\Controller::class, 'index'], 'route.first.2');

// Необязательный параметр "two". После слеша тоже необходимо ставить "*".
$route->get(
    'first/{two:[0-9]*}/*free/{name:[a-z0-9]+}/',
    [\App\Http\Controllers\Controller::class, 'index'],
    'route.first.222'
);

// получить ссылку для шаблона
var_dump($route->name('name1', ['two' => 45, 'name' => 'sergey']));
var_dump($route->name('name2', ['two' => 700, 'name' => 'vasya']));
var_dump($route->name('route.first.3'));

