<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 03.06.2017
 * Time: 17:42
 */

namespace Models;


class CategoriesModel extends ActiveRecord
{

    public static function loadById(int $id)
    {
        $result = Mysql::getOne("categories", ["id" => $id]);
        return new self($result);
    }
}