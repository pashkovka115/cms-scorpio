<?php

namespace Crm\Builder\Query;


use Crm\Database\DB;

class Select extends Base
{
    /**
     * @var array|string[]
     */
    private array $select_fields;


    public function __construct($table, array $select_fields = ['*'])
    {
        $this->table = $table;
        $this->select_fields = $select_fields;
        $this->fields = implode(', ', $select_fields);

        $this->generatedSimpleSql();

        return $this;
    }


    public function join($table, $type = '', $reference = false, $field = false)
    {
        if ($reference and $field){
            $sql = "\n$type JOIN $table ON $reference = $field;";
            $this->placeholders = rtrim($this->placeholders, ';') . $sql;
        }

        return $this;
    }


    /**
     * Подготавливает и выполняет выражение SQL.
     * Возвращает объект PDOStatement или false в случае возникновения ошибки.
     */
    public function query(array $params = [])
    {
        DB::setDriver(conf('app.db_driver'));
        $db = new DB();
        $stmt = $db->connect()->prepare($this->placeholders);
        $stmt->execute($params);

        return $stmt;
    }

    /**
     * Генерация простого sql, без join и тому подобного.
     * Генерирует строку полей и строку для подготовки запроса в БД
     */
    protected function generatedSimpleSql()
    {
        $this->placeholders = "SELECT {$this->fields} FROM {$this->table};";
    }
}
