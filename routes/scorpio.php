<?php

/** @var Crm\Route\Route $route */

$route->namespace('scorpio', function () use ($route) {
    \App\Modules\Scorpio\Admin\Users\Index::getRoutes($route, \App\Admin\Controllers\UsersController::class);
});
