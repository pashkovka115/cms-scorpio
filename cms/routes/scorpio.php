<?php

/** @var Crm\Route\Route $route */

$route->namespace('scorpio', function () use ($route) {
    $route->get('', [\App\Admin\Controllers\HomeController::class, 'index'], 'admin.home');
    /** @namespace users */
    \App\Modules\Scorpio\Admin\Users\Index::getRoutes($route, \App\Admin\Controllers\UsersController::class);

    $route->namespace('migrations', function () use ($route){
        $route->get('', [\App\Admin\Controllers\DB\MigrationController::class, 'index'], 'scorpio.migrations.index');
        $route->post('store', [\App\Admin\Controllers\DB\MigrationController::class, 'store'], 'scorpio.migrations.store');
        $route->post('destroy', [\App\Admin\Controllers\DB\MigrationController::class, 'destroy'], 'scorpio.migrations.destroy');
        $route->post('up', [\App\Admin\Controllers\DB\MigrationController::class, 'up'], 'scorpio.migrations.up');
        $route->post('up.all', [\App\Admin\Controllers\DB\MigrationController::class, 'upAll'], 'scorpio.migrations.up.all');
        $route->post('down', [\App\Admin\Controllers\DB\MigrationController::class, 'down'], 'scorpio.migrations.down');
        $route->post('down.all', [\App\Admin\Controllers\DB\MigrationController::class, 'downAll'], 'scorpio.migrations.down.all');
    });

    $route->namespace('modules', function () use ($route){
        $route->namespace('settings', function () use ($route){

        });
    });
});
