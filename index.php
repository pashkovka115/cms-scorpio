<?php
$start = microtime(true);


require $_SERVER['DOCUMENT_ROOT'] . '/cms/bootstrap.php';


\Crm\Route\Route::getInstance()->dispatch();





$end = microtime(true);
$time = $end - $start;

echo "<p>Скрипт отработал за $time </p>";