<?php
$start = microtime(true);

use Crm\Builder\Query\Query;
use App\Admin\Users;

require $_SERVER['DOCUMENT_ROOT'] . '/bootstrap.php';


\Crm\Route\Route::getInstance()->dispatch();


echo __FILE__;


$end = microtime(true);
$time = $end - $start;

echo "<p>Скрипт отработал за $time </p>";