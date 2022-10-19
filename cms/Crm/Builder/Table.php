<?php

namespace Crm\Builder;

use Crm\Database\DB;
use PDOException;

class Table
{
    private $table_name;
    private $before_sql = 'CREATE TABLE IF NOT EXISTS ';
    private $after_sql = "\n) ENGINE = ";
    private $column;
    private $sql = '';
    private $db;
    private $error = false;


    public function __construct()
    {
        $this->column = new Column();
        $this->db = new DB();
    }


    public function create(string $name, callable $func, string $engine = 'InnoDB', $collate = 'DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci')
    {
        $this->table_name = $name;
        $this->before_sql .= $name . ' (';
        $func($this->column);

        $this->sql = $this->before_sql
            . $this->column->getColumns()
            . $this->after_sql
            . $engine
            . ' '
            . $collate . ';';

        try {
            $this->db->exec($this->getSql());
        }catch (PDOException $exception){
            return $this->error = 'Ошибка! ' . $exception->getMessage() . ' Ошибка! ';
        }

        return $this->getSql();
    }


    public function exec()
    {
        $this->db->exec($this->getSql());
    }


    public function getSql()
    {
        return $this->sql;
    }


    public function addColumn(string $table_name, string $column_name, string $type, $length = false)
    {
        $this->sql = 'ALTER TABLE ' . $table_name . " \nADD " . $column_name . ' ' . $type;
        if ($length) {
            $this->sql .= "($length);";
        } else {
            $this->sql .= ";";
        }
    }


    public function dropColumn(string $table_name, string $column_name)
    {
        $this->sql = 'ALTER TABLE ' . $table_name . " \nDROP COLUMN " . $column_name;
    }


    public function dropTable(string $name)
    {
        $this->sql = 'DROP TABLE IF EXISTS ' . $name . ';';
    }


    public function truncateTable(string $name)
    {
        $this->sql = 'TRUNCATE TABLE ' . $name . ';';
    }


    public function deleteData(string $name)
    {
        $this->sql = 'DELETE FROM ' . $name . ';';
    }


    public function getErrorCode()
    {
        return $this->db->getErrorCode();
    }


    public function getErrorMessage()
    {
        return $this->error . $this->db->getErrorMessage();
    }

    public function hasError()
    {
        return $this->db->hasError() or (bool)$this->error;
    }
}
