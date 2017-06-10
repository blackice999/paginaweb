<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 03.06.2017
 * Time: 17:46
 */

namespace Controllers;


use Models\ProductModel;
use Models\ProductResourcesModel;
use Utils\HTMLGenerator;
use Utils\StringUtils;

abstract class BaseController implements Controller
{

    public function get()
    {
        // TODO: Implement get() method.
    }

    public function post()
    {
        // TODO: Implement post() method.
    }

    public function displayProducts(int $categoryId, string $categoryName)
    {
        if (empty(ProductModel::loadByCategoryId($categoryId))) {
            HTMLGenerator::tag("h2", "No " . StringUtils::removeUnderscore($categoryName) . " found");
        } else {

            foreach (ProductModel::loadByCategoryId($categoryId) as $product) {
                echo "<div class=\"column\" style='border: 1px solid black; padding: 10px; height: 400px;'>";

                //Display only the first image when viewing all products

                $productResourcesModel = ProductResourcesModel::loadByProductId($product->id);
                echo HTMLGenerator::image($productResourcesModel[0]->location, "",
                    "float-center",
                    "margin-bottom:30px; width:40%; height:40%");
                echo HTMLGenerator::link("product/" . $product->id, $product->name,
                    "float-center text-center", "margin-bottom:30px");

                echo " <ul>";
                $productSpecModel = $product->getProductSpecModel();
                foreach ($productSpecModel as $productSpec) {
                    echo "<li>" . $productSpec->name . ": ";

                    $productSpecDescriptionName = [];
                    foreach ($productSpec->getProductSpecDescriptionModel() as $productSpecDescriptionModel) {
                        $productSpecDescriptionName[] = $productSpecDescriptionModel->name;
                    }
                    echo implode(", ", $productSpecDescriptionName);
                    echo "</li>";

                    $productSpecModelLength = sizeof($productSpecModel);
                }
                echo "</ul>";

                if($productSpecModelLength < 3) {
                    for($i = 0; $i < (3 - $productSpecModelLength); $i++) {
                        echo "<br/>";
                    }
                }
                HTMLGenerator::tag("h3", "$" . $product->price, "", "border:1px solid black; float:left;");
                echo "</div>";
            }

            echo "</div>";
        }
    }

    public function insertNewProduct($name)
    {

        if (isset($_SESSION['userId'])) {
            HTMLGenerator::row(5, 5, 5);
            HTMLGenerator::tag("h2", "Add a new " . StringUtils::removeUnderscore(StringUtils::toSingular($name)));
            HTMLGenerator::form("post", $_GET['path'], [
                ["label" => "Name", "type" => "text", "name" => "name", "value" => ""],
                ["label" => "Description", "type" => "text", "name" => "description", "value" => ""],
                ["label" => "price", "type" => "text", "name" => "price", "value" => ""],
                ["label" => "Specification name", "type" => "text", "name" => "spec_name", "value" => ""],
                ["label" => "", "type" => "submit", "name" => "submit", "value" => "Insert motherboard"]
            ]);
        }
    }
}