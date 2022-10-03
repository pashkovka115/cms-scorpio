<?php


namespace Crm\Builder\Query;


use Crm\Database\DB;

abstract class Base
{
    protected string $table;
    protected array $params = [];
    protected string $fields;
    protected array $where;
    /**
     * @var string $placeholders - строка sql для подготовки запроса
     */
    protected string $placeholders;

    /**
     * Генерация простого sql, без join и тому подобного.
     * Генерирует строку полей и строку для подготовки запроса в БД
     */
    abstract protected function generatedSimpleSql();


    public function params($params = [])
    {
        $this->params = $params;
        if (count($params) > 0){
            $this->generatedSimpleSql();
        }

        return $this;
    }


    public function where($field, $operator = '=', $value = false, $logic = '')
    {
        if ($value === false){
            $value = $operator;
            $operator = '=';
        }
        if (is_string($value)){
            $value = "'".$value."'";
        }
        if (substr_count($this->placeholders, ' WHERE ') == 0){
            $sql = ' WHERE ';
        }else{
            $sql = " $logic ";
        }
        $sql .= "$field $operator $value;";
        $this->placeholders = rtrim($this->placeholders, ';') . $sql;

        return $this;
    }


    public function whereAnd($field, $operator = '=', $value = false)
    {
        return $this->where($field, $operator, $value, 'AND');
    }


    public function whereOR($field, $operator = '=', $value = false)
    {
        return $this->where($field, $operator, $value, 'OR');
    }

    // SELECT * FROM table WHERE id IN (1,2,3,4);
    public function whereIN($field, array $value = [])
    {
        $sql = " WHERE $field IN(";
        foreach ($value as $item){
            if (is_string($item)){
                $sql .= "'" . $item . "', ";
            }else{
                $sql .= $item . ', ';
            }
        }
        $sql = rtrim($sql, ', ') . ');';
        $this->placeholders = rtrim($this->placeholders, ';') . $sql;

        return $this;
    }


    /**
     * @return bool
     * @throws \Exception
     * Запускает SQL на выполнение
     * Возвращает true в случае успешного выполнения или false в случае возникновения ошибки.
     */
    public function exec()
    {
        try {
            $ids = [];
            DB::setDriver(conf('app.db_driver'));
            $db = new DB();
            $stmt = $db->connect()->prepare($this->placeholders);

            foreach ($this->params as $key => $param) {
                if (!is_numeric(array_key_first($this->params))) {
                    if (is_bool($param)) {
                        $this->params[$key] = (int)$param;
                    }
                    $stmt->execute($this->params);

                    return $db->lastInsertId();

                }elseif (is_numeric(array_key_first($this->params))){
                    $stmt->execute($param);
                    $ids[] = $db->lastInsertId();
                }
            }

            return $ids;

        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
}
