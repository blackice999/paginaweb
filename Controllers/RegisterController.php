<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 25.04.2017
 * Time: 19:08
 */

namespace Controllers;


use Utils\FormGenerator;
use Utils\HTMLGenerator;

class RegisterController implements Controller
{

    public function get()
    {
        HTMLGenerator::createRow(4);
        echo "<h2> Login</h2>";
        FormGenerator::generate("post", "register.php", [
            ["label" => "Username", "type" => "text", "name" => "username"],
            ["label" => "Email", "type" => "text", "name" => "email"],
            ["label" => "Password", "type" => "password", "name" => "password"]
        ]);
        HTMLGenerator::closeRow();
    }

    public function post()
    {
        // TODO: Implement post() method.
    }
}