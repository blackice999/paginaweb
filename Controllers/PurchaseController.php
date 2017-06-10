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

        if (!in_array($this->productId, $_SESSION['products']) && is_numeric($this->productId)) {
            $_SESSION['products'][] = $this->productId;
        }
    }

    public function get()
    {

        HTMLGenerator::row(12, 5, 5);
        HtmlGenerator::tag("h2", "In your cart");
        echo "<div class='callout'>";


        echo "<table>";

        echo "<tr>";
        echo "<th>Name </th>";
        echo "<th>Quantity</th>";
        echo "<th>Price</th>";
        echo "</tr>";
        foreach ($_SESSION['products'] as $productsId) {
            $product = ProductModel::loadById($productsId);
            echo "<tr>";
            echo "<td>" . $product->name . "</td>";
            echo "<td>" . 1 . "</td>";
            echo "<td>" . $product->price . "</td>";
            echo "</tr>";
        }
        echo "</table>";

        echo "</div>";


        HTMLGenerator::form("post", "/paginaweb/purchase/all", [
                ["label" => "", "type" => "submit", "name" => "buy", "value" => "Buy"]
            ]
        );
        HTMLGenerator::closeRow();
    }

    public function post()
    {

        HTMLGenerator::row(10, 10, 10);
        $sum = 0;

        foreach ($_SESSION['products'] as $productId) {
            $product = ProductModel::loadById($productId);
            ProductModel::buy($productId);
            $sum += $product->price;
        }

        echo $sum;
        HTMLGenerator::closeRow();
    }
}