<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 03.06.2017
 * Time: 18:05
 */

namespace Controllers;


use Models\ProductModel;
use Models\ProductResourcesModel;
use Models\ProductSpecModel;
use Utils\HTMLGenerator;

class ProductController implements Controller
{

    private $productId;

    /**
     * ProductController constructor.
     * @param int $productId
     */
    public function __construct(int $productId)
    {
        $this->productId = $productId;
    }

    public function get()
    {
        $product = ProductModel::loadById($this->productId);
        HTMLGenerator::row(12, 12, 12);
        HTMLGenerator::tag("h2", $product->name);
        HTMLGenerator::closeRow();
        HtmlGenerator::row(5, 5, 5);

        echo "<div class=\"orbit\" role=\"region\" aria-label=\"Favorite Space Pictures\" data-orbit>
         <ul class=\"orbit-container\">
        <button class=\"orbit-previous\"><span class=\"show-for-sr\">Previous Slide</span>&#9664;&#xFE0E;</button>
        <button class=\"orbit-next\"><span class=\"show-for-sr\">Next Slide</span>&#9654;&#xFE0E;</button>";

        $productResoucesModel = ProductResourcesModel::loadByProductId($this->productId);
        foreach ($productResoucesModel as $productResources) {
            HTMLGenerator::tag("li",
                HTMLGenerator::image($productResources->location, "", "orbit-image"),
                "orbit-slide");
        }
        echo "</ul>
        <nav class=\"orbit-bullets\">";

        $productResourcesLength = sizeof($productResoucesModel);

        //First button needs to be active, so set it here
        echo "<button class=\"is-active\" data-slide=\"1\">";
        HTMLGenerator::tag("span", "First slide details", "show-for-sr");
        HTMLGenerator::tag("span", "Current slide", "show-for-sr");
        echo "</button>";
        for ($i = 2; $i <= $productResourcesLength; $i++) {
            echo "<button data-slide=\"$i\">";
            HTMLGenerator::tag("span", "First slide details", "show-for-sr");
            HTMLGenerator::tag("span", "Current slide", "show-for-sr");
            echo "</button>";
        }
        echo "</nav>
</div>";

        echo "<div class='large-5  medium-5 small-5 columns>";
        echo "<div  style='border:1px solid black; width: 200px; height: 100px;'>";
        HtmlGenerator::row(1, 1, 1);
        echo "</div>";
        echo "</div>";
        HTMLGenerator::closeRow();
        echo "<div class='float-right'>";
        HTMLGenerator::tag("div", "$" . $product->price);
        echo "<br />";
        echo HTMLGenerator::link("purchase", "Buy");

        echo "</div>";

        //Content for the middle of the page
        if ($product->stock > 50) {
            HTMLGenerator::tag("b", "Stock plenty", "", "color:green;");
        } else if ($product->stock < 50 && $product->stock > 0) {
            HTMLGenerator::tag("b", "Stock shortage", "", "color: orange");
        } else {
            HTMLGenerator::tag("b", "Out of stock", "", "color:red");
        }

        if ($product->price > 100) {
            HTMLGenerator::tag("p", "Free shipping");
        }

        echo "</div>";

        HTMLGenerator::row(5, 5, 5);
        HTMLGenerator::tag("h2", "Technical specifications");

        echo "<table>";
        foreach ($product->getProductSpecModel() as $productSpecModel) {
            echo "<tr>";
            echo "<td> " . $productSpecModel->name . "</td>";
            echo "<td>";
            foreach ($productSpecModel->getProductSpecDescriptionModel() as $productSpecDescriptionModel) {
                echo $productSpecDescriptionModel->name . "<br />";
            }
            echo "</td>";
            echo "</tr>";
        }

        echo "</table>";
        HTMLGenerator::closeRow();
    }

    public function post()
    {
        // TODO: Implement post() method.
    }
}