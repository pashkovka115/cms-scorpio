<?php

namespace Crm\Models;


use Crm\Builder\Query\Insert;
use Crm\Collections\Collections;
use Crm\Builder\Query\Query;

class Model
{
    public static $table;


    public function __construct(array $data = [], array $black_list = [])
    {
        foreach ($data as $field => $value){
            if (is_string($field) and !in_array($field, $black_list)){
                $this->$field = $value;
            }
        }
    }


    public function save(array $data = [], array $black_list = [])
    {
        if (!$data){
            foreach ($this as $field => $value){
                if (!in_array($field, $black_list)){
                    $data[$field] = $value;
                }
            }
        }

        $insert = new Insert(static::$table, $data);

        return $insert->exec();
    }


    public static function find($id, $field = 'id', $collections = false, $mode = \PDO::FETCH_ASSOC)
    {
        if (!is_array($id)){
            $id = [$id];
        }
        $res = Query::select(static::$table)->whereIN($field, $id)->query();

        return self::formatDataAll($res, $collections, $mode);
    }


    public static function all(array $params = [], $collections = false, $mode = \PDO::FETCH_ASSOC)
    {
        $res = Query::select(static::$table)->query($params);

        return self::formatDataAll($res, $collections, $mode);
    }


    /**
     * @param $data
     * @param false $collections
     * @param int $mode
     * @return Collections|mixed
     * Служебный метод формирования результата.
     * Коллекция или стандартный вывод PHP
     */
    private static function formatDataAll(\PDOStatement $data, $collections = false, $mode = \PDO::FETCH_ASSOC){
        if ($data->rowCount() == 1){
            $tmp = $data->fetch($mode);
        }else{
            $tmp = $data->fetchAll($mode);
        }
        if ($collections){
            return new Collections($tmp);
        }
        return $tmp;
    }
}
