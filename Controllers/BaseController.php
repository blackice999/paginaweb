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

    public function displayAllProductsByCategory(string $mainCategoryPath, array $categories)
    {
        if (isset($_GET['path']) && $_GET['path'] !== $mainCategoryPath) {
            $this->{$_GET['path']}($_GET['path']);
        } else {
            foreach ($categories as $category) {
                $titleFromLink = StringUtils::removeUnderscore($category);
                HTMLGenerator::tag("h3", ucfirst($titleFromLink));
                echo HTMLGenerator::link($category, "Check all " . $titleFromLink);
            }
        }
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

                if (!empty($productResourcesModel)) {
                    echo HTMLGenerator::image($productResourcesModel[0]->location, "",
                        "float-center",
                        "margin-bottom:30px; width:40%; height:40%");
                } else {
                    echo HTMLGenerator::image("https://placehold.it/150x150", "",
                        "float-center",
                        "margin-bottom:30px; width:40%; height:40%");
                }
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

                }
                echo "</ul>";
                $productSpecModelLength = sizeof($productSpecModel);

                if ($productSpecModelLength < 3) {
                    for ($i = 0; $i < (3 - $productSpecModelLength); $i++) {
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