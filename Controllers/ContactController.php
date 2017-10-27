<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 13.04.2017
 * Time: 17:33
 */

namespace Controllers;


use Utils\HTMLGenerator;

class ContactController implements Controller
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
    public function get()
    {
        $this->showMenu();


        echo HTMLGenerator::tag("h2", "Working hours");
        $this->displayWorkingHours();

        echo "<div class='large-10 medium-3 small-3 columns'>";
        echo HTMLGenerator::tag("h3", "News and client support on social networks");
        echo "</div>";

        $this->displaySocialMediaLinks();
        echo "<div class='large-10 medium-3 small-3 columns'>";
       echo HTMLGenerator::tag("h3", "Contact details");
        echo "</div>";
        $this->displayContactDetails();
    }

    public function post()
    {
        // TODO: Implement post() method.
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

    private function displayWorkingHours() {
        echo "<div class='large-5 medium-3 small-3 columns'>";
        echo "<table>";
            echo "<tr>";
                echo "<td> Selling department:</td>";
                echo "<td> Monday-Friday 10:00 - 18:00</td>";
            echo "</tr>";

            echo "<tr>";
                echo "<td> Call Center department: </td>";
                echo "<td> Monday-Friday 09:00-19:00</td>";
            echo "</tr>";
            echo "<tr>";
                echo "<td> Warranty department: </td>";
                echo "<td> Monday-Friday:10:00 - 18:00</td>";
            echo "</tr>";
        echo "</table>";
        echo "</div>";
    }

    private function displaySocialMediaLinks() {
        echo "<div class='large-5 medium-3 small-3 columns'>";
                    echo HTMLGenerator::link("#",HTMLGenerator::image("https://placehold.it/100x100", "facebook"));
                    echo HTMLGenerator::tag("span", "Facebook");
                    echo HTMLGenerator::tag("br", "");
                    echo HTMLGenerator::link("#",HTMLGenerator::image("https://placehold.it/100x100", "twitter"));
                    echo HTMLGenerator::tag("span", "Twitter");
                    echo HTMLGenerator::tag("br", "");

                    echo HTMLGenerator::link("#",HTMLGenerator::image("https://placehold.it/100x100", "instagram"));
                    echo HTMLGenerator::tag("span", "Instagram");
        echo "</div>";
    }

    private function displayContactDetails() {
        echo "<div class='large-5 medium-3 small-3 columns'>";
        echo "<table>";
             echo "<tr>";
                echo "<td> Adress contact:</td>";
                echo "<td> George Cosbuc str. 30/20 Baia Mare</td>";
             echo "</tr>";

            echo "<tr>";
              echo "<td> GPS coordinates: </td>";
              echo "<td> Latitude:100,425341 Longitude: 45,325439</td>";
             echo "</tr>";
             echo "<tr>";
                 echo "<td>Call center telephone:	 </td>";
                 echo "<td> 023 343 56 76</td>";
             echo "</tr>";
        echo "</table>";
        echo "</div>";

    }
}