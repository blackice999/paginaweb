<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 20.06.2017
 * Time: 20:46
 */

namespace Models;


class OrderProductsModel extends ActiveRecord
{
    public static function loadById(int $id)
    {
        $result = Mysql::getOne("order_products", ["id" => $id]);
        return new self($result);
    }

    public static function create(int $orderId, int $productId)
    {
        $result = Mysql::insert("order_products",
            [
                "order_id" => $orderId,
                "product_id" => $productId
            ]
        );

        return self::loadById($result);
    }
}