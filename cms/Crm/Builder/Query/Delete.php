<?php

namespace Crm\Builder\Query;


use Crm\Database\DB;

class Delete extends Base
{
    public function __construct($table)
    {
        $this->table = $table;
        $this->generatedSimpleSql();

        return $this;
    }


    /**
     * Генерация простого sql, без join и тому подобного
     */
    protected function generatedSimpleSql()
    {

        $this->placeholders = "DELETE FROM {$this->table}";
    }


    public function params($params = [])
    {
        throw new \Exception('Метод ' . __METHOD__ . ' не используется');
    }


    public function exec()
    {
        try {
            DB::setDriver(conf('app.db_driver'));
            $db = new DB();
            $stmt = $db->connect()->prepare($this->placeholders);

            return $stmt->execute();

        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
}
