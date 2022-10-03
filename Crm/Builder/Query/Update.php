<?php

namespace Crm\Builder\Query;


use Crm\Database\DB;

class Update extends Base
{
    public function __construct($table, array $params = [])
    {
        $this->table = $table;
        $this->params = $params;
        if (count($params) > 0){
            $this->generatedSimpleSql();
        }

        return $this;
    }


    /**
     * Генерация простого sql, без join и тому подобного
     */
    protected function generatedSimpleSql()
    {
        $this->fields = '';
        $this->placeholders = '';
        $fields = '';

        foreach ($this->params as $placeholder => $param){
            if (!is_array($param)){
                $fields .= "$placeholder = :$placeholder, ";
            }elseif (is_array($param)){
                foreach ($param as $field => $value){
                    $fields .= "$field = :$field, ";
                }
                break;
            }
        }

        $fields = rtrim($fields, ', ') . ';';

        $this->fields = $fields;
        $this->placeholders = "UPDATE {$this->table} SET $fields";
    }


    public function exec()
    {
        foreach ($this->params as $key => $param){
            if (is_bool($param)){
                $this->params[$key] = (int)$param;
            }
        }

        try {
            DB::setDriver(conf('app.db_driver'));
            $db = new DB();
            $stmt = $db->connect()->prepare($this->placeholders);

            if (!is_numeric(array_key_first($this->params))){
                $stmt->execute($this->params);

                return $db->lastInsertId();
            }else{
                throw new \Exception('Масив должен быть одномерным');
            }
        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
}
