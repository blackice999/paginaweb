<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 20.06.2017
 * Time: 20:28
 */

namespace Models;


class OrdersModel extends ActiveRecord
{
    public static function loadById(int $id)
    {
        $result = Mysql::getOne("orders", ["id" => $id]);
        return new self($result);
    }

    public static function create(int $userId, string $invoiceName)
    {
        $result = Mysql::insert("orders",
            [
                "user_id" => $userId,
                "invoice_name" => $invoiceName,
                "date" => date("Y-m-d H:i:s")
            ]
        );

        return self::loadById($result);
    }
}