<?php

use App\Modules\Scorpio\PostList\Index;

require $_SERVER['DOCUMENT_ROOT'] . '/bootstrap.php';

?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Список постов на странице сайта</title>
</head>
<body>
<?php
echo __FILE__;
//\Crm\Modules::includeModule(Index::class, []);
?>
</body>
</html>
