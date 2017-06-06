<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 06.06.2017
 * Time: 12:55
 */

namespace Models;


class ProductResourcesModel extends ActiveRecord
{
    protected $productModel;

    public static function loadByProductId(int $id)
    {
        $results = Mysql::getMany("product_resources", ['product_id' => $id]);

        $productResourceModel = [];
        foreach ($results as $result) {
            $productResourceModel[] = new static($result);
        }

        return $productResourceModel;
    }

    public static function loadById(int $id)
    {
        $result = Mysql::getOne("product_resources", ["id" => $id]);
        return new self($result);
    }

    public function getProductModel()
    {
        if (is_null($this->productModel)) {
            $this->productModel = ProductSpecModel::loadByProductId($this->id);
        }

        return $this->productModel;
    }

    public static function create(int $productId, string $tableName, string $location, string $mimeType)
    {
        $result = Mysql::insert($tableName, ["product_id" => $productId, "location" => $location, "mine_type" => $mimeType]);
        return self::loadById($result);
    }
}