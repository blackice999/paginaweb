<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 14.05.2017
 * Time: 14:17
 */

namespace Models;


class ProductModel extends ActiveRecord
{

    protected $productSpecModel;

    public static function loadByCategoryId(int $id)
    {
        $results = Mysql::getMany("products", ['category_id' => $id]);

        $computerPartsModel = [];
        foreach ($results as $result) {
            $computerPartsModel[] = new static($result);
        }

        return $computerPartsModel;
    }

    public function getProductSpecModel()
    {
        if (is_null($this->productSpecModel)) {
            $this->productSpecModel = ProductSpecModel::loadByProductId($this->id);
        }

        return $this->productSpecModel;
    }
}