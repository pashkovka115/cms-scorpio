<?php

/** @var Crm\Route\Route $route */

$route->namespace('scorpio', function () use ($route) {
    /** @namespace users */
    \App\Modules\Scorpio\Admin\Users\Index::getRoutes($route, \App\Admin\Controllers\UsersController::class);

    $route->namespace('migrations', function () use ($route){
        $route->get('', [\App\Admin\Controllers\MigrationController::class, 'index'], 'scorpio.migrations.index');
        $route->post('store', [\App\Admin\Controllers\MigrationController::class, 'store'], 'scorpio.migrations.store');
        $route->post('destroy', [\App\Admin\Controllers\MigrationController::class, 'destroy'], 'scorpio.migrations.destroy');
        $route->post('up', [\App\Admin\Controllers\MigrationController::class, 'up'], 'scorpio.migrations.up');
        $route->post('up.all', [\App\Admin\Controllers\MigrationController::class, 'upAll'], 'scorpio.migrations.up.all');
        $route->post('down', [\App\Admin\Controllers\MigrationController::class, 'down'], 'scorpio.migrations.down');
        $route->post('down.all', [\App\Admin\Controllers\MigrationController::class, 'downAll'], 'scorpio.migrations.down.all');
    });

    $route->namespace('modules', function () use ($route){
        $route->namespace('settings', function () use ($route){

        });
    });
});
