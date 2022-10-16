<?php

return [
    /* Домен */
    'host' => 'http://cms-orm.loc',

    /* Настройки подключения к базе данных */
    'pdo_options' => [
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
    ],
    'db_driver' => 'mysql',
    'db' => [
        'mysql' => [
            'host' => 'localhost',
            'port' => 3306,
            'dbname' => 'crm',
            'username' => 'root',
            'password' => '123'
        ],
    ],
    'default_view_path' => $_SERVER['DOCUMENT_ROOT'] . '/App/Http/Views'

    // 'disk' => [],
    // '...' => '...'
];
