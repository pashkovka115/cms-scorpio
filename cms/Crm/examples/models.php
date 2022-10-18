<?php
$users = Users::all();
$users = Users::find([19, 22]);

var_dump($users);