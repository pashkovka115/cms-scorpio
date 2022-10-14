<?php

/** @var Crm\Route\Route $route */



$route->namespace('first', function () use ($route){
    $route->get('/two/free', function (){
        echo __FILE__;
    });
});








//echo '<pre>'; print_r($route->getRoutes()); echo '</pre>';
