<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 03.06.2017
 * Time: 17:46
 */

namespace Controllers;


use Models\ProductModel;
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

            foreach (ProductModel::loadByCategoryId($categoryId) as $category) {
                echo "<div class=\"column\" style='border: 1px solid black; padding: 10px; height: 400px;'>";
                echo HTMLGenerator::image("//placehold.it/150x150", "placeholder 150x150",
                    "float-center", "margin-bottom:30px");
                echo HTMLGenerator::link("product/" . $category->id, $category->name,
                    "float-center text-center", "margin-bottom:30px");

                echo " <ul>";
                foreach ($category->getProductSpecModel() as $productSpecModel) {
                    echo "<li>" . $productSpecModel->name . "</li>";
                }
                echo "</ul>";

                HTMLGenerator::tag("h3", "$" . $category->price);
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