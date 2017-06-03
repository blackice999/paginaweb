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
                echo HTMLGenerator::link("motherboards/" . $category->id, $category->name,
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
}