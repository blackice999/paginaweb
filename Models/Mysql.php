<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 25.04.2017
 * Time: 17:45
 */

namespace Models;


use Models\Exceptions\ConnectionException;
use Models\Exceptions\QueryException;

class Mysql
{
    private static $connection = null;

    private function __construct()
    {
    }

    private static function getConnection()
    {
        if (is_null(self::$connection)) {
            self::$connection = new \mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE_NAME);

            if (self::$connection->connect_error) {
                throw new ConnectionException("Can't connect to database " . DB_DATABASE_NAME);
            }
        }

        return self::$connection;
    }

    private function query(string $sql)
    {
        $result = self::getConnection()->query($sql);

        if (self::getConnection()->errno > 0) {
            throw new QueryException(self::getConnection()->error, self::getConnection()->errno);
        }

        return $result;
    }

    public static function insert(string $tableName, array $data)
    {
        $sql = "INSERT INTO " . $tableName . "(";

        $columnNames = $columnValues = [];
        foreach ($data as $columnName => $columnValue) {
            $columnNames[] = "`" . $columnName . "`";
            $columnValues[] = '"' . self::getConnection()->escape_string($columnValue) . '"';
        }

        $sql .= implode(",", $columnNames) . ")";

        $sql .= "VALUES(" . implode(",", $columnValues) . ")";
        self::query($sql);

        return self::getConnection()->insert_id;
    }

}