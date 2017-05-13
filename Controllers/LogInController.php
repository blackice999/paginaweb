<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 13.05.2017
 * Time: 14:26
 */

namespace Controllers;


use Models\UserModel;
use Utils\HTMLGenerator;
use Utils\StringUtils;

class LogInController implements Controller
{
    private $errors = [];

    public function get()
    {
        HTMLGenerator::row(4);
        HTMLGenerator::tag("h2", "Log In");

        HTMLGenerator::form("post", "log_in", [
                ["label" => "Email", "type" => "email", "name" => "email", "value" => ""],
                ["label" => "Password", "type" => "password", "name" => "password", "value" => ""],
                ["label" => "", "type" => "submit", "name" => "login", "value" => "Login"]
            ]
        );
        HTMLGenerator::closeRow();
    }

    public function post()
    {
        if (isset($_POST['login'])) {
            $email = StringUtils::sanitizeString($_POST['email']);
            $password = StringUtils::sanitizeString($_POST['password']);

            if (empty($email)) {
                $this->errors[] = "Email is empty";
            }

            if (empty($password) || strlen($password) < 6) {
                $this->errors[] = "Should be between longer than 6 characters";
            }


            if (!UserModel::userExists($email)) {
                $this->errors[] = "User does not exist";
            }

            $userModel = UserModel::loadByEmail($email);

            $password = StringUtils::encryptPassword("adsfasf");
            if (password_verify($password, $userModel->password)) {
                $this->errors[] = "Passwords do not match";
            }

            if (!empty($errors)) {
                var_dump($this->errors);
            } else {
                HTMLGenerator::row(5,5,5);
                HTMLGenerator::tag("h2","Successfully logged in");
                HTMLGenerator::closeRow();
                $_SESSION['userId'] = $userModel->id;

            }
        }
    }
}