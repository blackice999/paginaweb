<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 14.05.2017
 * Time: 16:07
 */

namespace Models;


class ProductSpecModel extends ActiveRecord
{

    public static function loadByProductId(int $id) {
        $results = Mysql::getMany("product_specs", ['product_id' => $id]);

        $productSpecModel = [];
        foreach($results as $result) {
            $productSpecModel[] = new static($result);
        }

        return $productSpecModel;
    }
}