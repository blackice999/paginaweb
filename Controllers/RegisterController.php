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
        HTMLGenerator::row(4);
        echo HTMLGenerator::tag("h2", "Register");

        HTMLGenerator::form("post", "register", [
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

            if (UserModel::userExists($email)) {
                $this->errors[] = "Email already taken";
            }

            if (empty($password) || strlen($password) < 6) {
                $this->errors[] = "Password should be longer than 6 characters";
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

                HTMLGenerator::row(4, 4, 4);
                echo HTMLGenerator::tag("h2", "Successfully inserted user");
                HTMLGenerator::closeRow();
            }
        }
    }
}