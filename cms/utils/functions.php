<?php
function redirect($url){
    header('Location: ' . $url);
    exit();
}
function d(...$data)
{
    echo '<pre>';
    foreach ($data as $datum){
        print_r($datum);
    }
    echo '</pre>';
}
function dd(...$data)
{
    echo '<pre>';
    foreach ($data as $datum){
        print_r($datum);
    }
    echo '</pre>';
    die();
}

function base_path()
{
    return $_SERVER['DOCUMENT_ROOT'] . '/cms';
}

function base_url()
{
    return conf('app.host');
}

function conf(string $key = '', string $dir = 'registry', $sep = DIRECTORY_SEPARATOR)
{
    $sp = explode('.', $key);
    foreach ($sp as $k => $v) {
        if ($v == '') {
            unset($sp[$k]);
        }
    }
    if (count($sp) > 0) {
        $path = base_path() . $sep . $dir . $sep . $sp[0] . '.php';
        $file = require $path;
        foreach ($sp as $k => $val) {
            if ($k == 0) continue;
            $file = $file[$val];
        }
        return $file;
    }
    return false;
}
