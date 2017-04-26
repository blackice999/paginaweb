<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 25.04.2017
 * Time: 19:08
 */

namespace Controllers;


use Models\Mysql;
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
        if(isset($_POST['register'])) {
            $name = explode(" ", $_POST['name']);
            $firstName = $name[0];
            $lastName = $name[1];

            Mysql::insert("users", [
                "first_name" => $firstName,
                "last_name" => $lastName,
                "username" => $_POST['username'],
                "email" => $_POST['email'],
                "password" => $_POST['password']
            ]);

            echo "Succesfully inserted user";
        }
    }
}