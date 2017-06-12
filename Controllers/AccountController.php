<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 13.05.2017
 * Time: 13:17
 */

namespace Controllers;


use Models\UserAddressesModel;

use Utils\HTMLGenerator;
use Utils\StringUtils;

class AccountController implements Controller
{
    private $errors = [];

    public function get()
    {
        HTMLGenerator::row(5, 5, 5);
        echo HTMLGenerator::tag("h2", "Your informations");

        echo HTMLGenerator::tag("h3", "Biling addresses");

        if (!UserAddressesModel::isAddressSet($_SESSION['userId'])) {
            echo HTMLGenerator::tag("p", "No address set");
        } else {

            foreach (UserAddressesModel::loadByUserId($_SESSION['userId']) as $addresses) {
                echo $addresses->address . "<br />";
            }
        }

        echo HTMLGenerator::tag("h3", "Add a new address");
        HTMLGenerator::form("post", "account", [
            ["label" => "Address", "type" => "text", "name" => "address", "value" => ""],
            ["label" => "", "type" => "submit", "name" => "new_address", "value" => "Insert"]
        ]);
        HTMLGenerator::closeRow();
    }

    public function post()
    {
        if (isset($_POST['new_address'])) {
            $address = StringUtils::sanitizeString($_POST['address']);
            $userId = $_SESSION['userId'];

            UserAddressesModel::create($userId, $address);
            echo HTMLGenerator::tag("p", "Added address, redirecting to your account page");
            header("Location: account");
        }
    }
}