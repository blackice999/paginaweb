<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 25.04.2017
 * Time: 19:08
 */

namespace Controllers;


use Models\UserModel;
use Utils\HTMLGenerator;
use Utils\StringUtils;

class RegisterController implements Controller
{

    private $errors = [];

    public function get()
    {
        HTMLGenerator::createRow(4);
        echo "<h2> Register</h2>";
        HTMLGenerator::generateForm("post", "register", [
            ["label" => "Full name", "type" => "text", "name" => "name", "value" => ""],
            ["label" => "Username", "type" => "text", "name" => "username", "value" => ""],
            ["label" => "Email", "type" => "text", "name" => "email", "value" => ""],
            ["label" => "Password", "type" => "password", "name" => "password", "value" => ""],
            ["label" => "Repeat password", "type" => "password", "name" => "repeat_password", "value" => ""],
            ["label" => "", "type" => "submit", "name" => "register", "value" => "Register"]
        ]);
        HTMLGenerator::closeRow();
    }

    public function post()
    {
        if (isset($_POST['register'])) {
            $name = StringUtils::sanitizeString($_POST['name']);

            $username = StringUtils::sanitizeString($_POST['username']);
            $password = StringUtils::sanitizeString($_POST['password']);
            $repeatPassword = StringUtils::sanitizeString($_POST['repeat_password']);
            $email = StringUtils::sanitizeString($_POST['email']);

            if (empty($name)) {
                $this->errors[] = "Name is empty";
            }

            if (empty($username)) {
                $this->errors[] = "Username is empty";
            }

            if (empty($email)) {
                $this->errors[] = "Email is empty";
            }

            if ($password != $repeatPassword) {
                $this->errors[] = "Passwords do not match";
            }

            if (!empty($this->errors)) {
                //TODO - add a better error display
                var_dump($this->errors);
            } else {
                $password = StringUtils::encryptPassword($password);

                UserModel::create($name, $username, $email, $password);

                HTMLGenerator::createRow(4, 4, 4);
                echo "<p>Successfully inserted user</p>";
                HTMLGenerator::closeRow();
            }
        }
    }
}