<?php

/** @var Crm\Route\Route $route */

$route->namespace('scorpio', function () use ($route) {
    $route->namespace('migrations', function () use ($route){

        $route->get('create', [\App\Admin\Controllers\MigrationController::class, 'create'], 'migrations.create');

    });
});
