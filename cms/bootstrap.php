<?php

require $_SERVER['DOCUMENT_ROOT'] . '/cms/utils/functions.php';

spl_autoload_register(function($class){
    $class = str_replace('\\', '/', $class);
    require $class . '.php';
});