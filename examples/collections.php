<?php

$users = Users::all([], true);

//var_dump($users->sortBy('price')->keyAsFild('id')->get());
var_dump($users->keyAsFild('id')->arsort()->get());
