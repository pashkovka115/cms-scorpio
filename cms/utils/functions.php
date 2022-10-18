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

function conf(string $key = '', string $dir = 'conf', $sep = DIRECTORY_SEPARATOR)
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

function status_code(int $code, $redirect = true){
    switch ($code) {
        case 100:
            $text = 'Continue';
            break;
        case 101:
            $text = 'Switching Protocols';
            break;
        case 200:
            $text = 'OK';
            break;
        case 201:
            $text = 'Created';
            break;
        case 202:
            $text = 'Accepted';
            break;
        case 203:
            $text = 'Non-Authoritative Information';
            break;
        case 204:
            $text = 'No Content';
            break;
        case 205:
            $text = 'Reset Content';
            break;
        case 206:
            $text = 'Partial Content';
            break;
        case 300:
            $text = 'Multiple Choices';
            break;
        case 301:
            $text = 'Moved Permanently';
            break;
        case 302:
            $text = 'Moved Temporarily';
            break;
        case 303:
            $text = 'See Other';
            break;
        case 304:
            $text = 'Not Modified';
            break;
        case 305:
            $text = 'Use Proxy';
            break;
        case 400:
            $text = 'Bad Request';
            break;
        case 401:
            $text = 'Unauthorized';
            break;
        case 402:
            $text = 'Payment Required';
            break;
        case 403:
            $text = 'Forbidden';
            break;
        case 404:
            $text = 'Not Found';
            break;
        case 405:
            $text = 'Method Not Allowed';
            break;
        case 406:
            $text = 'Not Acceptable';
            break;
        case 407:
            $text = 'Proxy Authentication Required';
            break;
        case 408:
            $text = 'Request Time-out';
            break;
        case 409:
            $text = 'Conflict';
            break;
        case 410:
            $text = 'Gone';
            break;
        case 411:
            $text = 'Length Required';
            break;
        case 412:
            $text = 'Precondition Failed';
            break;
        case 413:
            $text = 'Request Entity Too Large';
            break;
        case 414:
            $text = 'Request-URI Too Large';
            break;
        case 415:
            $text = 'Unsupported Media Type';
            break;
        case 500:
            $text = 'Internal Server Error';
            break;
        case 501:
            $text = 'Not Implemented';
            break;
        case 502:
            $text = 'Bad Gateway';
            break;
        case 503:
            $text = 'Service Unavailable';
            break;
        case 504:
            $text = 'Gateway Time-out';
            break;
        case 505:
            $text = 'HTTP Version not supported';
            break;
    }
    $protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');
    header($protocol . ' ' . $code . ' ' . $text);

    if ($redirect){
        $file = base_path() . "/errors/$code.php";
        if (file_exists($file)){
            require $file;
        }
    }
}
