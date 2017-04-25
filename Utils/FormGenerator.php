<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 25.04.2017
 * Time: 19:09
 */

namespace Utils;


class FormGenerator
{
    private $method;
    private $action;
    private $validInputTypes = ["text", "email", "password", "date", "submit"];
    private $data;

    public static function generate(string $method, string $action, array $data)
    {
        $labels = array_column($data, "label");
        $types = array_column($data, "type");
        $names = array_column($data, "name");

        foreach($data as $key => $value['label']) {
            foreach($value as $item) {
                echo $item;
            }
        }

        echo "<form method=$method action=$action>";

        echo "</form>";

        var_dump($labels);


        $values = [
            ["label" => "Username", "type" => "text", "name" => "username"],
            ["label" => "Email", "type" => "text", "name" => "email"],
            ["label" => "Password", "type" => "password", "name" => "password"]
        ];
    }


}