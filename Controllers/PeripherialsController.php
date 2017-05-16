<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 13.04.2017
 * Time: 17:31
 */

namespace Controllers;


use Models\ProductModel;
use Models\ProductSpecModel;
use Utils\HTMLGenerator;
use Utils\StringUtils;

class PeripherialsController implements Controller
{
    private $categories = ["monitors", "mice", "keyboards", "external_hdds"];
    const MONITORS_CATEGORY_ID = 10;
    const MICE_CATEGORY_ID = 11;
    const KEYBOARDS_CATEGORY_ID = 12;
    const EXTERNAL_HDDS_CATEGORY_ID = 13;

    public function get()
    {
        if (isset($_GET['path']) && $_GET['path'] !== "peripherials") {
            $this->{$_GET['path']}($_GET['path']);
        } else {
            foreach ($this->categories as $category) {
                $titleFromLink = StringUtils::removeUnderscore($category);
                HTMLGenerator::tag("h3", ucfirst($titleFromLink));
                HTMLGenerator::link($category, "Check all " . $titleFromLink);
            }
        }
    }

    public function post()
    {
        if (isset($_POST['submit'])) {
            $categoryId = constant("self::" . strtoupper($_GET['path']) . "_CATEGORY_ID");
            $name = StringUtils::sanitizeString($_POST['name']);
            $description = StringUtils::sanitizeString($_POST['description']);
            $price = StringUtils::sanitizeString($_POST['price']);
            $specName = StringUtils::sanitizeString($_POST['spec_name']);

            $result = ProductModel::create($categoryId, "products", $name, $description, $price);
            HTMLGenerator::tag("p", "Inserted new " . StringUtils::toSingular($_GET['path']) . " with the id " . $result->id);
            ProductSpecModel::create("product_specs", $result->id, $specName);
        }
    }

    public function __call($name, $arguments)
    {
        $categoryId = constant("self::" . strtoupper($arguments[0]) . "_CATEGORY_ID");

        echo "<div class=\"row small-up-2 medium-up-5 large-up-3\" style='margin-top:10px;'>";

        if (empty(ProductModel::loadByCategoryId($categoryId))) {
            HTMLGenerator::tag("h2", "No " . StringUtils::removeUnderscore($name) . " found");
        } else {

            foreach (ProductModel::loadByCategoryId($categoryId) as $category) {
                echo "<div class=\"column\" style='border: 1px solid black; padding: 10px; height: 400px;'>";
                HTMLGenerator::image("//placehold.it/150x150", "placeholder 150x150",
                    "float-center", "margin-bottom:30px");
                HTMLGenerator::link("motherboards/" . $category->id, $category->name,
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

        HTMLGenerator::row(5, 5, 5);
        HTMLGenerator::tag("h2", "Add a new " . StringUtils::removeUnderscore(StringUtils::toSingular($name)));
        HTMLGenerator::form("post", $_GET['path'], [
            ["label" => "Name", "type" => "text", "name" => "name", "value" => ""],
            ["label" => "Description", "type" => "text", "name" => "description", "value" => ""],
            ["label" => "price", "type" => "text", "name" => "price", "value" => ""],
            ["label" => "Specification name", "type" => "text", "name" => "spec_name", "value" => ""],
            ["label" => "", "type" => "submit", "name" => "submit", "value" => "Insert motherboard"]
        ]);
        HTMLGenerator::closeRow();
    }
}