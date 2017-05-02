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
    private static $validMethodTypes = ["post", "get"];
    private $data;

    public static function generate(string $method, string $action, array $data)
    {

         if(!in_array($method, self::$validMethodTypes)) {
            throw new Exceptions\MethodNotValid("Method " . $method . " is not a valid method type");
        }

        echo "<form method=$method action=$action>";

        foreach($data as $input) {
            echo "<label>" . $input['label'] . "</label>";

            if($input['type'] === "submit") {
                echo "<input type=" . $input['type'] . " class='button' name=" . $input['name'] . " value=" . $input['value'] . ">";     
            } else {
                echo "<input type=" . $input['type'] . " name=" . $input['name'] . " value=" . $input['value'] . ">"; 
            }
        }

        echo "</form>";
    }


}