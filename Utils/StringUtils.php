<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 13.05.2017
 * Time: 14:17
 */

namespace Utils;


class StringUtils
{
    public static function encryptPassword(string $password) {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public static function sanitizeString(string $value) {
        return filter_var($value, FILTER_SANITIZE_STRING);
    }

    public static function removeUnderscore(string $value) {
        return str_replace("_", " ", $value);
    }

    public static function toSingular(string $value) {
        //Remove "s" from the end
        $category = substr($category, 0, strlen($category) - 1);

        //If the last two characters are "ie", convert them to "y"
        if (substr($category, strlen($category) - 2) === "ie") {
            $category = substr($category, 0, strlen($category) - 2) . "y";
        }

        return $category;
    }
}