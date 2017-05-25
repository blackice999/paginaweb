<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 13.04.2017
 * Time: 17:32
 */

namespace Controllers;


use Models\Mysql;
use Utils\HTMLGenerator;

class InformationsController implements Controller
{

    private static $menu = [
        "contact" => [
            "Contact us" => [
                "contact" => "Contact"
            ]
        ],
        "orders" => [
            "Orders" => [
                "how_to_order" => "How to order",
                "shipping_term" => "Shipping term",
                "terms" => "Terms and conditions",
                "order_state" => "Order state",
                "client_advantages" => "Client advantages",
                "order_cancellation" => "Order cancellation",
                "product_availability" => "Product availability"
            ]
        ],
        "returns_warranty" => [
            "Returns and warranty" => [
                "return_policy" => "Return policy",
                "warranty_conditions" => "Warranty conditions",
                "how_to_proceed" => "How do I proceed"
            ]
        ],
        "payment_methods" => [
            "Payment methods" => [
                "repayment" => "Repayment",
                "with_card" => "With card",
                "cash_hq" => "Cash at the HQ",
                "rates" => "Rates"
            ]
        ],
        "delivery" => [
            "Delivery" => [
                "costs" => "Costs",
                "methods" => "Methods",
                "urgent_delivery" => "Urgent delivery in Baia Mare in just 3 hours"
            ]
        ],
        "about_us" => [
            "About us" => [
                "company" => "Company",
                "products" => "Products"
            ]
        ]
    ];

    public function post()
    {
        //Tested delete a user from login page
        if (isset($_POST['login'])) {
            $username = $_POST['username'];

            // FIX - Will always return true even if the value does not exist
            var_dump(Mysql::delete("users", ["username" => $username]));
            if((Mysql::delete("users", ["username" => $username]))) {
                echo "Succesfully deleted user " . $username;
            } else {
                echo "user does not exist";
            }
        }
    }

    public function get()
    {
        $this->showMenu();

        echo "<pre>";
        $result = Mysql::getMany("users");
        var_dump($result);


        echo "<div class='large-5 medium-5 small-5 columns'>";

            echo "<table border='1'>";
                echo "<tr>";
                    echo "<th> First Name</th>";
                    echo "<th> Last Name </th>";
                    echo "<th> Username </th>";
                    echo "<th> Email </th>";
                echo "</tr>";

                echo "<tr>";
                    echo "<td> " . $result[0]['first_name'] . "</td>";
                    echo "<td> " . $result[0]['last_name'] . "</td>";
                    echo "<td> " . $result[0]['username'] . "</td>";
                    echo "<td> " . $result[0]['email'] . "</td>";
                echo "</tr>";
            echo "<table>";
        echo "</div>";

    }

    private function showMenu()
    {
        echo "<div class='large-2 medium-3 small-3 columns'>";
        echo "<ul class='vertical menu'>";
        foreach (self::$menu as $mainLinks => $mainTitles) {
            foreach ($mainTitles as $title => $subLinks) {
                echo "<li>" . HTMLGenerator::link($mainLinks, $title, "", "background-color:#D0D0D0") . "</li>";
                foreach ($subLinks as $link => $value) {
                    echo "<ul class='nested vertical menu'>";
                             echo "<li>" . HTMLGenerator::link($link, $value) . "</li>";
                        echo "</ul>";
                }
            }
        }

        echo "</ul>";
        echo "</div>";
    }
}