<?php

namespace Crm\Models;


use Crm\Collections\Collections;
use Crm\Builder\Query\Query;

class Model
{
    public static $table;


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
