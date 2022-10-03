<?php

use CRM\Builder\Column;
use Crm\Builder\Table;
use Crm\Database\DB;

require $_SERVER['DOCUMENT_ROOT'] . '/bootstrap.php';



// $db = new DB();

$table = new Table();

$sql = $table->create('users', function (Column $column) {
    $column->id();
    $column->string('name')->nullable();
    $column->text('description')->nullable();
    // $column->enum('enum_field', ['val1', 'val2', 'val3']);
    $column->boolean('bool_field', [0, 1]);
    $column->decimal('price')->nullable();
    $column->integer('num_field')->nullable();
    $column->tinyint('tiny_field')->nullable();
    $column->bigint('bigint_field')->nullable();
});


if ($table->hasError()){
    var_dump($table->getErrorMessage());
}else{
    echo '<p>Ошибок нет.</p>';
}


// var_dump($db->exec($table->getSql()));
// var_dump($db->connect()->errorInfo());

// $table->addColumn('users', 'email', 'VARCHAR', 32);
// var_dump($table->getSql());
