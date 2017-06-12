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

class PurchaseController implements Controller
{
    private $productId;

    /**
     * PurchaseController constructor.
     * @param $productId
     */
    public function __construct($productId)
    {
        $this->productId = $productId;

        if (!isset($_SESSION['products'])) {
            $_SESSION['products'] = [];
        }

        if (!in_array($this->productId, $_SESSION['products']) && is_numeric($this->productId)) {
            $_SESSION['products'][] = $this->productId;
        }
    }

    public function get()
    {

        HTMLGenerator::row(12, 5, 5);
        HtmlGenerator::tag("h2", "In your cart");
        $sum = 0;
        echo "<div class='callout'>";

        echo "<table id='cart'>";

        echo "<tr>";
        echo "<th>Name </th>";
        echo "<th>Quantity</th>";
        echo "<th>Price</th>";
        echo "<th>Remove</th>";
        echo "</tr>";

        echo "<form method='post' action='/paginaweb/purchase/all'>";
        foreach ($_SESSION['products'] as $productsId) {
            $product = ProductModel::loadById($productsId);
            echo "<tr>";
            echo "<td>" . $product->name . "</td>";
            echo "<td class='quan'> <input class='quantity' type='number' name='quantity[]' value='1'></td>";
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
    }

    public function post()
    {
        HTMLGenerator::row(10, 10, 10);

        $sum = 0;
        $numberOfProducts = sizeof($_SESSION['products']);

        for ($i = 0; $i < $numberOfProducts; $i++) {
            $quantity = StringUtils::sanitizeString($_POST['quantity'][$i]);
            $productId = $_SESSION['products'][$i];
            $product = ProductModel::loadById($productId);
            ProductModel::buy($productId, $quantity);
            $sum += $product->price;
        }

        HTMLGenerator::tag("h3", "Thanks for your purchase");
        HTMLGenerator::tag("p", "Your products will arrive at your destination in 4 working days");
        unset($_SESSION['products']);
        HTMLGenerator::closeRow();
    }
}