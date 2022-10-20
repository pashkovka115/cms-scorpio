<?php

require $_SERVER['DOCUMENT_ROOT'] . '/cms/bootstrap.php';

echo \Crm\Modules::includeModule(\App\Modules\Scorpio\Items\Index::class, [
    'id' => 'id', // первичный ключ в таблице
    'table' => 'posts',
    'fields' => ['title', 'anons'],
    'references' => [
        'one_to_many' => [
            'user_id:users.id' => ['name']
        ],
        'many_to_many' => [],
    ],
]);

/*
SELECT posts.title, posts.anons, users.name FROM posts
LEFT JOIN users ON users.id = posts.user_id
 */
