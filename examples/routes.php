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
