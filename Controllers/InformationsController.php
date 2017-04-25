<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 13.04.2017
 * Time: 17:32
 */

namespace Controllers;


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
        if (isset($_POST['login'])) {
            echo "it is login in informations";
        }
    }

    public function get()
    {
        $this->showMenu();
    }

    private function showMenu()
    {
        echo "<div class='large-2 medium-3 small-3 columns'>";
        echo "<ul class='vertical menu'>";
        foreach (self::$menu as $mainLinks => $mainTitles) {
            foreach ($mainTitles as $title => $subLinks) {
                echo "<li><a href=$mainLinks style='background-color: #D0D0D0;'>$title</a></li>";
                foreach ($subLinks as $link => $value) {
                    echo "<ul class='nested vertical menu'>
                             <li><a href=$link>$value</a></li>
                        </ul>";

                }
            }
        }

        echo "</ul>";
        echo "</div>";
    }
}