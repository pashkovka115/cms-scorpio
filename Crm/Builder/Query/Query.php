<?php


namespace Crm\Builder\Query;


use Crm\Database\DB;

class Query
{
    private static Insert $insert;
    private static Update $update;
    private static Delete $delete;
    private static Select $select;


    public static function insert($table, $params = [])
    {
        return self::$insert = new Insert($table, $params);
    }

    public static function update($table, $params = [])
    {
        return self::$update = new Update($table, $params);
    }

    public static function delete($table)
    {
        return self::$delete = new Delete($table);
    }


    public static function select($table, array $select_fields = ['*'])
    {
        return self::$select = new Select($table, $select_fields);
    }


    /**
     * @param $sql
     * @param array $params
     * @return bool
     * Подготавливает и выполняет выражение SQL.
     * Возвращает true в случае успешного выполнения или false в случае возникновения ошибки.
     */
    public static function execute($sql, $params = [])
    {
        DB::setDriver(conf('app.db_driver'));
        $db = new DB();
        $stmt = $db->connect()->prepare($sql);

        return $stmt->execute($params);
    }


    /**
     * @param $sql
     * @param array $params
     * @return false|\PDOStatement
     * Подготавливает и выполняет выражение SQL.
     * Возвращает объект PDOStatement или false в случае возникновения ошибки.
     */
    public static function query($sql, $params = [])
    {
        DB::setDriver(conf('app.db_driver'));
        $db = new DB();
        $stmt = $db->connect()->prepare($sql);
        $stmt->execute($params);

        return $stmt;
    }
}