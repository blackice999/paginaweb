<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 25.04.2017
 * Time: 17:45
 */

namespace Models;


use Models\Exceptions\ConnectionException;
use Models\Exceptions\NoResultsException;
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

    public static function getOne(string $tableName, array $where)
    {
        $sql = "SELECT * FROM `" . $tableName . "` WHERE ";

        foreach ($where as $key => $value) {
            $sql .= '`' . $key . '` = "' . self::getConnection()->escape_string($value) . '" AND ';
        }

        $sql = rtrim($sql, " AND ");

        $result = mysqli_fetch_assoc(self::query($sql));

        if (empty($result)) {
            throw new NoResultsException("no results in table " . $tableName . " by " . json_encode($where));
        }

        return $result;
    }

    public static function getMany(string $tableName, string $type, array $where)
    {

        //TO USE - mysqli_fetch_all
        $sql = "SELECT * FROM " . $tableName . " WHERE ";

        foreach ($where as $key => $value) {
            $sql .= '`' . $key . '` = "' . self::getConnection()->escape_string($value) . '" AND ';
        }

        $sql = rtrim($sql, " AND ");

        $result = self::query($sql);

        //Return an associative array of the result
        $array = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $array[$type][] = $row;
        }

        if (empty($result)) {
            throw new Exceptions\NoResultsException('no results in table ' . $tableName . ' by ' . json_encode($where));
        }

        return $array;
    }

    public static function delete(string $tableName, array $where)
    {
        $sql = "DELETE FROM " . $tableName . " WHERE ";

        foreach ($where as $key => $value) {
            $sql .= '`' . $key . '` = "' . self::getConnection()->escape_string($value) . '" AND ';
        }


        $sql = rtrim($sql, " AND ");

        return self::query($sql);
    }

    public static function update(string $tableName, array $data, array $where)
    {
        $sql = "UPDATE `" . $tableName . "` SET ";

        foreach ($data as $columnName => $columnValue) {
            $sql .= '`' . $columnName . '` = "' . self::getConnection()->escape_string($columnValue) . '",';
        }

        $sql = rtrim($sql, ",");
        $sql .= " WHERE ";


        foreach ($where as $columnName => $columnValue) {
            $sql .= '`' . $columnName . '` = "' . self::getConnection()->escape_string($columnValue) . '" AND ';
        }

        $sql = rtrim($sql, " AND ");

        return self::query($sql);
    }

}