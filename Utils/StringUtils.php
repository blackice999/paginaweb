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
}