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
    protected $productSpecDescriptionModel;

    public static function loadByProductId(int $id) {
        $results = Mysql::getMany("product_specs", ['product_id' => $id]);

        $productSpecModel = [];
        foreach($results as $result) {
            $productSpecModel[] = new static($result);
        }

        return $productSpecModel;
    }

    public static function loadById(int $id) {
        $result = Mysql::getOne("product_specs", ["id" => $id]);
        return new self($result);
    }

    public function getProductSpecDescriptionModel()
    {
        if (is_null($this->productSpecDescriptionModel)) {
            $this->productSpecDescriptionModel = ProductSpecDescriptionModel::loadByProductSpecId($this->id);
        }

        return $this->productSpecDescriptionModel;
    }
    public static function create(int $productId, string $name) {
        $result = Mysql::insert("product_specs", ["product_id" => $productId, "name" => $name]);
        return self::loadById($result);
    }
}