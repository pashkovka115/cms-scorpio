<?php

//use Crm\Builder\Query\Insert;
use Crm\Builder\Query\Query;

require $_SERVER['DOCUMENT_ROOT'] . '/bootstrap.php';


Query::delete('users')
    ->where('id', '=', 11)
    ->whereAnd('price', '>', 99)
    ->whereOR('price', '<', 200)
    ->where('num_field', '=', 11, 'AND')
    ->exec();


Query::update('users')->params([
//    'name' => 'Old Имя',
//    'description' => 'Old Описание',
//    'bool_field' => true,
    'price' => 100,
//    'num_field' => 11,
//    'tiny_field' => 3,
//    'bigint_field' => 111,
])
    ->where(['id' => 10,])
    ->exec();

/*Query::update('users')->params([
    [
        'name' => 'Имя1',
        'description' => 'Описание1',
        'bool_field' => true,
        'price' => 52.6,
        'num_field' => 11,
        'tiny_field' => 3,
        'bigint_field' => 111,
    ],
    [
        'name' => 'Имя2',
        'description' => 'Описание2',
        'bool_field' => true,
        'price' => 52.6,
        'num_field' => 11,
        'tiny_field' => 3,
        'bigint_field' => 111,
    ],
])->exec();*/

/*$query->insert('users', [
    'name' => 'Имя3',
    'description' => 'Описание3',
    'bool_field' => true,
    'price' => 52.6,
    'num_field' => 11,
    'tiny_field' => 3,
    'bigint_field' => 111,
])->exec();*/

/*Query::insert('users', [
    [
        'name' => 'Имя4',
        'description' => 'Описание4',
        'bool_field' => true,
        'price' => 52.6,
        'num_field' => 11,
        'tiny_field' => 3,
        'bigint_field' => 111,
    ],
    [
        'name' => 'Имя5',
        'description' => 'Описание5',
        'bool_field' => true,
        'price' => 52.6,
        'num_field' => 11,
        'tiny_field' => 3,
        'bigint_field' => 111,
    ],
])->exec();*/


// id	name	description	bool_field	price	num_field	tiny_field	bigint_field

/*$res = Query::insert('users', [
    'name' => 'Sergey',
    'description' => 'Description',
    'bool_field' => true,
    'price' => 10.52,
    'num_field' => 10,
    'tiny_field' => 11,
    'bigint_field' => 111,
])->exec();*/

/*$res = Query::update('users', [
    'name' => 'Sergey updated',
//    'description' => 'Description',
    'bool_field' => false,
    'price' => 20.02,
//    'num_field' => 10,
//    'tiny_field' => 11,
//    'bigint_field' => 111,
])->exec();*/

//$res = Query::delete('users')->where('id', '=', 17)->exec();

//var_dump($res);

$res = Query::query('SELECT * FROM users WHERE id = :id', [
    ':id' => 19
]);

var_dump($res->fetch());
var_dump($res->fetchAll());

$res = Query::delete('users')
    ->where('id', '=', 19)
    ->exec();

$res = Query::select('users', ['users.id', 'users.name'])
    ->where('id', 18)
    ->query();


// Выборка из трёх таблиц
$res = Query::select('users', [
    'users.id users_id',
    'users.name users_name',
    'users.description users_description',
    'users.bool_field users_bool_field',
    'users.price users_price',
    'users.num_field users_num_field',
    'users.tiny_field users_tiny_field',
    'users.bigint_field users_bigint_field',
    'addresses.id addresses_id',
    'addresses.user_id addresses_user_id',
    'addresses.title addresses_title',
    'bio.id bio_id',
    'bio.user_id bio_user_id',
    'bio.title bio_title',
])
    ->join('addresses', 'LEFT', 'users.id', 'addresses.user_id')
    ->join('bio', 'LEFT', 'users.id', 'bio.user_id')
    ->where('users.id', 18)
    ->query();


