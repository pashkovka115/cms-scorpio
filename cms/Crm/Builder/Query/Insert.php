<?php

namespace Crm\Builder\Query;


use Crm\Database\DB;

class Insert extends Base
{
    public function __construct($table, array $params = [])
    {
        $this->table = $table;
        $this->params = $params;
        if (count($params) > 0){
            $this->generatedSimpleSql();
        }
    }

    /**
     * Генерация простого sql, без join и тому подобного.
     * Генерирует строку полей и строку для подготовки запроса в БД
     */
    protected function generatedSimpleSql()
    {
        $this->fields = '';
        $this->placeholders = '';
        $fields = '(';
        $params = '(';

        foreach ($this->params as $placeholder => $param){
            if (!is_array($param)){
                $params .= ':' . $placeholder . ', ';
                $fields .= $placeholder . ', ';
            }elseif (is_array($param)){
                foreach ($param as $field => $value){
                    $fields .= $field . ', ';
                    $params .= ':' . $field . ', ';
                }
                break;
            }
        }
        $fields = rtrim($fields, ', ') . ')';
        $params = rtrim($params, ', ') . ')';

        $this->fields = $fields;
        $this->placeholders = "INSERT INTO {$this->table} $fields VALUES $params";
    }
}
