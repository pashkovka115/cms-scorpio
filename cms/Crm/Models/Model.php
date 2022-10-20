<?php

namespace Crm\Models;


use Crm\Builder\Query\Delete;
use Crm\Builder\Query\Insert;
use Crm\Builder\Query\Query;
use Crm\Builder\Query\Update;
use Crm\Collections\Collections;

class Model
{
    public static $table;
//    public static array $references = [];


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


    /**
     * @param $related - Зависящая модель
     * @param $this_field - Поле этой модели
     * @param $to_field - Ссылается на это поле
     * @param string[] $fields - выбрать только эти поля
     * @return array
     * Преобразовать вывод https://www.php.net/manual/ru/pdostatement.fetch.php
     * int $mode = PDO::FETCH_DEFAULT
     */
    protected static function hasMany($related, $this_field, $to_field, $fields = ['*'], $mode = null)
    {
        $static_table = static::$table;
        $related_table = $related::$table;

        $this_item = Query::select($static_table)->query()->fetch(\PDO::FETCH_ASSOC);
        $res = Query::select($related_table, $fields)->where($to_field, '=', $this_item[$this_field])->query();

        return $res->fetchAll($mode);
    }


    protected static function hasOne($related, $this_field, $to_field, $fields = ['*'], $mode = null)
    {
        $static_table = static::$table;
        $related_table = $related::$table;

        $this_item = Query::select($static_table)->query()->fetch(\PDO::FETCH_ASSOC);
        $res = Query::select($related_table, $fields)->where($to_field, '=', $this_item[$this_field])->query();

        return $res->fetch($mode);
    }


    public static function destroy($id, $field = 'id')
    {
        $delete = new Delete(static::$table);

        return $delete->where($field, '=', $id)->exec();
    }


    public static function update($id, array $data, $field = 'id')
    {
        $update = new Update(static::$table, $data);

        return $update->where($field, '=', $id)->exec();
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
