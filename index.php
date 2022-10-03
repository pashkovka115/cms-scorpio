<?php

use Crm\Builder\Query\Query;
use App\Http\Users;

require $_SERVER['DOCUMENT_ROOT'] . '/bootstrap.php';


$users = Users::find([19, 22]);

var_dump($users);

/*$res = Query::select('users')
    ->whereIN('id', [19, 21])
    ->query();
var_dump($res->fetchAll());*/



