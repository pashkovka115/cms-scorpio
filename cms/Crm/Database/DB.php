<?php
namespace Crm\Database;

use PDO;
use PDOException;

class DB
{
    private $connect;
    /**
     * @var string
     */
    private $errorMessage = '';
    /**
     * @var int|mixed
     */
    private $errorCode;
    private $lastSql;
    private static string $driver = 'mysql';


    /**
     * DB constructor.
     * @param string $driver
     * @return PDO
     */
    public function __construct()
    {
        switch (self::$driver) {
            case 'mysql':
                $db = conf('app.db.mysql');
                $dsn = "mysql:dbname={$db['dbname']};host={$db['host']}:{$db['port']}";
                try {
                    $this->connect = new PDO($dsn, $db['username'], $db['password'], conf('app.pdo_options'));
                }catch (PDOException $exception){
                    $this->errorMessage = $exception->getMessage();
                    $this->errorCode = $exception->getCode();
                }
        }

        return $this->connect;
    }


    /**
     * Возвращает текущее соединение
     */
    public function connect()
    {
        return $this->connect;
    }


    public function exec(string $sql)
    {
        $this->lastSql = $sql;

        return $this->connect()->exec($sql);
    }


    public function lastInsertId()
    {
        return $this->connect()->lastInsertId();
    }


    /**
     * @return string
     */
    public function getErrorMessage(): string
    {
        return $this->errorMessage . ' - ' . $this->lastSql;
    }


    /**
     * @return int|mixed
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }


    public function hasError()
    {
        return (bool)$this->errorMessage;
    }

    public static function setDriver($driver)
    {
        self::$driver = $driver;
    }

    public static function getDriver()
    {
        return self::$driver;
    }
}
