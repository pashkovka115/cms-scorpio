<?php


use Crm\Builder\Column;
use Crm\Builder\Table;

require $_SERVER['DOCUMENT_ROOT'] . '/cms/bootstrap.php';


class Test extends Column{
    public function getSql()
    {
        return parent::getSql(); // TODO: Change the autogenerated stub
    }
}
/*$column = new Test();


$column->id();
$column->integer('user_id')->unsigned();
$column->string('name')->nullable();
$column->text('description')->nullable();
$column->foreignKey('posts', 'user_id', 'user', 'id');

d($column->getSql());*/



//$table = new Table();

/*$sql = $table->create('posts', function (Column $column) {
    $column->id();
    $column->integer('user_id')->unsigned();
    $column->string('title');
    $column->text('anons')->nullable();
    $column->text('description')->nullable();
    $column->string('img')->nullable();
//    $column->foreignKey('posts', 'user_id', 'users', 'id');
});*/

//$table->addForeignKey('posts', 'user_id', 'users', 'id');
//$table->dropForeignKey('posts', 'user_id', 'users', 'id');

//$table->dropTable('posts');
//$table->exec();

//d($sql);

















