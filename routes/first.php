<?php

/** @var Crm\Route\Route $route */



$route->get(
    'first/{two:[0-9]*}/*free/{name:[a-z0-9]+}/',
    [\App\Http\Controllers\Controller::class, 'index'],
    'first.controller.index'
);

/*var_dump($route->name(
    'route.first.222',
    ['two' => 45, 'name' => 'john'],
    ['*']
));*/

//echo '<pre>'; print_r($route->getRoutes()); echo '</pre>';

