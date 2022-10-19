<?php

use CRM\Builder\Column;
use Crm\Builder\Table;


class Migrate_100000__19_10_2022_14_55_00_users {
    public function up()
    {
        $table = new Table();

        $table->create('users', function (Column $column) {
            $column->id();
            $column->string('name');
            $column->string('email');
        });
    }


    public function down()
    {
        $table = new Table();
         $table->dropTable('users');
         $table->exec();
    }
}
