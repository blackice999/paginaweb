<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 10.06.2017
 * Time: 16:23
 */

namespace Controllers;


use Models\ProductModel;
use Utils\HTMLGenerator;
use Utils\StringUtils;

class CartController implements Controller
{
    /**
     * PurchaseController constructor.
     * @param $productId
     */
    public function __construct()
    {
//        $this->productId = $productId;

        if (!isset($_SESSION['products'])) {
            $_SESSION['products'] = [];
        }

        if (isset($_GET['purchase'])) {
            $productId = StringUtils::sanitizeString($_GET['product_id']);

            if (!in_array($productId, $_SESSION['products']) && is_numeric($productId)) {
                $_SESSION['products'][] = $productId;
            }
        }
    }

    public function get()
    {
        if (isset($_SESSION['products'])) {
            HTMLGenerator::row(12, 5, 5);

            if (empty($_SESSION['products'])) {
                echo HTMLGenerator::tag("h2", "Your cart is empty");
            } else {
                echo HtmlGenerator::tag("h2", "In your cart");
                $sum = 0;
                echo "<div class='callout'>";

                echo "<table id='cart'>";

                echo "<tr>";
                echo "<th>Name </th>";
                echo "<th>Quantity</th>";
                echo "<th>On stock</th>";
                echo "<th>Price</th>";
                echo "<th>Remove</th>";
                echo "</tr>";

                echo "<form method='post' action='/paginaweb/cart'>";
                foreach ($_SESSION['products'] as $productsId) {
                    $product = ProductModel::loadById($productsId);
                    echo "<tr>";
                    echo "<td>" . $product->name . "</td>";
                    echo "<td> <input class='quantity' type='number' name='quantity[]' value='1'></td>";
                    echo "<td>" . $product->stock . "</td>";
                    echo "<td class='price'>" . $product->price . "</td>";
                    echo "<td> Yes</td>";
                    echo "</tr>";

                    $sum += $product->price;
                }

                echo "</table>";

                echo "</div>";

                echo "<input type='submit' class='button' name='buy' value='Buy'>";
                echo "</form>";

                echo "<div id='test'></div>";
                echo HTMLGenerator::tag("h4",
                    "Total " . HTMLGenerator::tag("span", $sum, "total"),
                    "float-right");
                HTMLGenerator::closeRow();
                HTMLGenerator::row(10, 10, 10);
            }
        }
    }

    public function post()
    {
        if (isset($_POST['buy'])) {
            $sum = 0;
            $numberOfProducts = sizeof($_SESSION['products']);

            for ($i = 0; $i < $numberOfProducts; $i++) {
                $quantity = StringUtils::sanitizeString($_POST['quantity'][$i]);
                $productId = $_SESSION['products'][$i];
                $product = ProductModel::loadById($productId);
                ProductModel::buy($productId, $quantity);
                $sum += $product->price;
            }

            echo HTMLGenerator::tag("h3", "Thanks for your purchase");
            echo HTMLGenerator::tag("p", "Your products will arrive at your destination in 4 working days");
            unset($_SESSION['products']);
            header("Refresh: 5; URL= index");

            HTMLGenerator::closeRow();
        }
    }
}