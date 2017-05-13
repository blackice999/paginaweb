<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 25.04.2017
 * Time: 19:20
 */

namespace Utils;


class HTMLGenerator
{
    private $validInputTypes = ["text", "email", "password", "date", "submit"];
    private static $validMethodTypes = ["post", "get"];

    /**
     * @param int $largeColumnSize The size of the column on large displays
     * @param int $mediumColumnSize The size of the column on medium displays
     * @param int $smallColumnSize The size of the column on small displays
     */
    public static function createRow(int $largeColumnSize, int $mediumColumnSize = 8, int $smallColumnSize = 10) {
        echo "<div class='row'>
           <div class='large-$largeColumnSize medium-$mediumColumnSize small-$smallColumnSize columns'>";
    }

    /**
     * Will close the row, as it is not good to leave hanging HTML tags
     */
    public static function closeRow() {
        echo "</div> </div>";
    }

    public static function generateForm(string $method, string $action, array $data)
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