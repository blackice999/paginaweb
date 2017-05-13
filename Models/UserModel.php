<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 13.05.2017
 * Time: 13:24
 */

namespace Models;


use Models\Exceptions\NoResultsException;

class UserModel extends ActiveRecord
{
    public static function userExists(string $email): bool
    {
        try {
            self::loadByEmail($email);
            return true;
        } catch (NoResultsException $e) {
            return false;
        }

    }

    public static function loadById(int $id)
    {
        $result = Mysql::getOne("users", ['id' => $id]);
        return new self($result);
    }

    public static function loadByEmail(string $email)
    {
        $result = Mysql::getOne("users", ['email' => $email]);
        return new self($result);
    }

    public static function create(string $fullName, string $username, string $email, string $password): self
    {
        $fullName = explode(" ", $fullName);
        $firstName = $fullName[0];
        $lastName = $fullName[1];

        $id = Mysql::insert("users", [
            "first_name" => $firstName,
            "last_name" => $lastName,
            "username" => $username,
            "email" => $email,
            "password" => $password
        ]);

        return self::loadById($id);
    }

}