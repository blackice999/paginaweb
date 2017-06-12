<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 03.06.2017
 * Time: 20:06
 */

namespace Models;


class ProductSpecDescriptionModel extends ActiveRecord
{
    protected $productSpecDescriptionModel;

    public static function loadById(int $id)
    {
        $result = Mysql::getOne("product_spec_description", ["id" => $id]);
        return new self($result);
    }

    public static function loadByProductSpecId(int $id)
    {
        $results = Mysql::getMany("product_spec_description", ['product_spec_id' => $id]);

        $productSpecDescriptionModel = [];
        foreach ($results as $result) {
            $productSpecDescriptionModel[] = new static($result);
        }

        return $productSpecDescriptionModel;
    }

    public static function create(int $productSpecId, string $name)
    {
        $result = Mysql::insert("product_spec_description",
            [
                "product_spec_id" => $productSpecId,
                "name" => $name
            ]
        );
        return self::loadById($result);
    }
}