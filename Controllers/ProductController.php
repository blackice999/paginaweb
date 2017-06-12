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
use Models\ProductSpecDescriptionModel;
use Models\ProductSpecModel;
use Utils\HTMLGenerator;
use Utils\StringUtils;

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
        echo HTMLGenerator::tag("h2", $product->name);
        HTMLGenerator::closeRow();
        HtmlGenerator::row(5, 5, 5);

        echo "<div class=\"orbit\" role=\"region\" aria-label=\"Favorite Space Pictures\" data-orbit>
         <ul class=\"orbit-container\">
        <button class=\"orbit-previous\"><span class=\"show-for-sr\">Previous Slide</span>&#9664;&#xFE0E;</button>
        <button class=\"orbit-next\"><span class=\"show-for-sr\">Next Slide</span>&#9654;&#xFE0E;</button>";

        $productResoucesModel = ProductResourcesModel::loadByProductId($this->productId);
        foreach ($productResoucesModel as $productResources) {
            echo HTMLGenerator::tag("li",
                HTMLGenerator::image($productResources->location, "", "orbit-image"),
                "orbit-slide");
        }
        echo "</ul>
        <nav class=\"orbit-bullets\">";

        $productResourcesLength = sizeof($productResoucesModel);

        //First button needs to be active, so set it here
        echo "<button class=\"is-active\" data-slide=\"1\">";
        echo HTMLGenerator::tag("span", "First slide details", "show-for-sr");
        echo HTMLGenerator::tag("span", "Current slide", "show-for-sr");
        echo "</button>";
        for ($i = 2; $i <= $productResourcesLength; $i++) {
            echo "<button data-slide=\"$i\">";
            echo HTMLGenerator::tag("span", "First slide details", "show-for-sr");
            echo HTMLGenerator::tag("span", "Current slide", "show-for-sr");
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
        echo HTMLGenerator::tag("div", "$" . $product->price);
        echo "<br />";
        HTMLGenerator::form("get", "../cart", [
            ['label' => "", "type" => "hidden", "name" => "product_id", "value" => $product->id],
            ['label' => "", "type" => "submit", "name" => "purchase", "value" => "Purchase"]
        ], "float-right");

        echo "</div>";

        //Content for the middle of the page
        if ($product->stock > 50) {
            echo HTMLGenerator::tag("b", "Stock plenty", "", "color:green;");
        } else if ($product->stock < 50 && $product->stock > 0) {
            echo HTMLGenerator::tag("b", "Stock shortage", "", "color: orange");
        } else {
            echo HTMLGenerator::tag("b", "Out of stock", "", "color:red");
        }

        if ($product->price > 100) {
            echo HTMLGenerator::tag("p", "Free shipping");
        }

        echo "</div>";

        HTMLGenerator::row(11,11,11);
        echo "<div class='callout'>";
        echo $product->description;
        echo "</div>";
        HTMLGenerator::closeRow();
        HTMLGenerator::row(5, 5, 5);
        echo HTMLGenerator::tag("h2", "Technical specifications");

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
        $this->addNewSpecificationForm();
        $this->modifyProductForm();

    }

    public function modifyProductForm()
    {
        if (isset($_SESSION['userId'])) {
            HTMLGenerator::row(5, 5, 5);
            echo HTMLGenerator::tag("h2", "Modify this product");
            HTMLGenerator::form("post", $_GET['path'], [
                ["label" => "Name", "type" => "text", "name" => "name", "value" => ""],
                ["label" => "Description", "type" => "text", "name" => "description", "value" => ""],
                ["label" => "price", "type" => "text", "name" => "price", "value" => ""],
                ["label" => "Specification name", "type" => "text", "name" => "spec_name", "value" => ""],
                ["label" => "Specification description", "type" => "text", "name" => "spec_description", "value" => ""],
                ["label" => "Stock", "type" => "number", "name" => "stock", "value" => ""],
                ["label" => "", "type" => "submit", "name" => "modify_product", "value" => "Modify"]
            ]);

            HTMLGenerator::closeRow();
        }
    }

    public function addNewSpecificationForm()
    {
        if (isset($_SESSION['userId'])) {
            HTMLGenerator::row(5, 5, 5);
            echo HTMLGenerator::tag("h2", "Add new specification, separate description by comma");
            HTMLGenerator::form("post", "../" . $_GET['path'], [
                ["label" => "Name", "type" => "text", "name" => "name", "value" => ""],
                ["label" => "Description", "type" => "text", "name" => "description", "value" => ""],
                ["label" => "", "type" => "submit", "name" => "new_spec", "value" => "Insert"]
            ]);

            HTMLGenerator::closeRow();
        }
    }

    public function post()
    {
        if (isset($_POST['new_spec'])) {
            echo $this->productId;
            $name = StringUtils::sanitizeString($_POST['name']);
            $description = StringUtils::sanitizeString($_POST['description']);
            $descriptionPieces = explode(", ", $description);

            $spec = ProductSpecModel::create($this->productId, $name);

            foreach ($descriptionPieces as $descriptionPiece) {
                ProductSpecDescriptionModel::create($spec->id, $descriptionPiece);
            }
        }
    }
}