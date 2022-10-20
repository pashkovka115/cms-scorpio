<?php

use CRM\Builder\Column;
use Crm\Builder\Table;


class Migrate_100001__19_10_2022_16_14_10_posts {
    public function up()
    {
        $table = new Table();

        $table->create('posts', function (Column $column) {
            $column->id();
            $column->integer('user_id')->unsigned();
            $column->string('title');
            $column->text('anons')->nullable();
            $column->text('description')->nullable();
            $column->string('img')->nullable();
            $column->foreignKey('posts', 'user_id', 'users', 'id');
        });
    }


    public function down()
    {
        $table = new Table();
         $table->dropForeignKey('posts', 'user_id', 'users', 'id');
         $table->exec();

        $table->dropTable('posts');
        $table->exec();
    }
}
