<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 12.06.2017
 * Time: 17:13
 */

namespace Models;


use Models\Exceptions\NoResultsException;

class UserAddressesModel extends ActiveRecord
{

    public static function loadById(int $id)
    {
        $result = Mysql::getOne("user_addresses", ['id' => $id]);
        return new self($result);
    }

    public static function loadByUserId(int $userId)
    {
        $results = Mysql::getMany("user_addresses", ['user_id' => $userId]);
        $userAddressesModel = [];
        foreach($results as $result) {
            $userAddressesModel[] = new static($result);
        }

        return $userAddressesModel;
    }

    public static function create(int $userId, string $address): self
    {
        $id = Mysql::insert("user_addresses", [
            "user_id" => $userId,
            "address" => $address
        ]);

        return self::loadById($id);
    }

    public static function isAddressSet(int $userId)
    {
        try {
            self::loadByUserId($userId);
            return true;
        } catch (NoResultsException $e) {
            return false;
        }
    }
}