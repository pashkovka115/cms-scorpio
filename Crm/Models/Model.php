<?php

namespace Crm\Models;


use Crm\Builder\Query\Query;

class Model
{
    public static $table;


    public static function find($id, $field = 'id', $mode = \PDO::FETCH_ASSOC)
    {
        if (!is_array($id)){
            $id = [$id];
        }
        $res = Query::select(static::$table)->whereIN($field, $id)->query();

        return $res->fetchAll($mode);
    }


    public static function all(array $params = [], $mode = \PDO::FETCH_ASSOC)
    {
        $res = Query::select(static::$table)->query($params);

        return $res->fetchAll($mode);
    }
}
