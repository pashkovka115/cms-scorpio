<?php

//use Crm\Route\Route;

//$route = Route::getInstance();

/** @var Crm\Route\Route $route */


/*$route->namespace('mynamespace', function () use ($route){
    $route->get('first/two/free', function (){
        echo __FILE__;
    }, 'route.first.1');
});*/


$route->get('first/two/free', function (){
    echo __FILE__;
}, 'route.first.2');



/*$route->namespace('mynamespace3', function () use ($route){

    $route->namespace('mynamespace33', function () use ($route){
        $route->get('first/two/free', function (){
            echo __FILE__;
        }, 'route.first.3');
    });

    // mynamespace3/mynamespace44/mynamespace55/first/two/free
    $route->namespace('mynamespace44', function () use ($route){
        $route->namespace('mynamespace55', function () use ($route){

            $route->get('first/two/free', function (){
                echo __FILE__;
            }, 'route.first.4');

        });
    });

    $route->namespace('mynamespace77', function () use ($route){
        $route->get('first/two/free', function (){
            echo __FILE__;
        });

        $route->any(['get', 'post'], 'MY/first/two/free', function (){
            echo __FILE__;
        }, 'route.first.5');

    });
});*/


//var_dump($route->name('route.first.4'));


//echo '<pre>'; print_r($route->getRoutes()); echo '</pre>';
