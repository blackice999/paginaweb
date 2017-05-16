<?php
/**
 * Created by PhpStorm.
 * User: L13
 * Date: 08/05/2017
 * Time: 08:40
 */

namespace Controllers;


use Models\ProductModel;
use Models\ProductSpecModel;
use Utils\HTMLGenerator;
use Utils\StringUtils;

class ComputerPartsController implements Controller
{
    private $categories = ["motherboards", "video_cards", "processors", "ssds", "hdds", "power_supplies", "chassis"];
    const MOTHERBOARDS_CATEGORY_ID = 2;
    const VIDEO_CARDS_CATEGORY_ID = 3;
    const PROCESSORS_CATEGORY_ID = 4;
    const SSDS_CATEGORY_ID = 5;
    const HDDS_CATEGORY_ID = 6;
    const POWER_SUPPLIES_CATEGORY_ID = 7;
    const CHASSIS_CATEGORY_ID = 8;

    public function get()
    {
        if (isset($_GET['path']) && $_GET['path'] !== "computer_parts") {
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
        echo $_GET['path'];
        if (isset($_POST['submit']) && $_GET['path'] === "motherboards") {
            $name = StringUtils::sanitizeString($_POST['name']);
            $description = StringUtils::sanitizeString($_POST['description']);
            $price = StringUtils::sanitizeString($_POST['price']);
            $specName = StringUtils::sanitizeString($_POST['spec_name']);

            $result = ProductModel::create("products", $name, $description, $price);
            HTMLGenerator::tag("p", "Inserted new motherboard with the id " . $result->id);
            ProductSpecModel::create("product_specs", $result->id, $specName);
        }
    }

    public function __call($name, $arguments)
    {
        $categoryId = constant("self::" . strtoupper($arguments[0]) . "_CATEGORY_ID");

        echo "<div class=\"row small-up-2 medium-up-5 large-up-3\" style='margin-top:10px;'>";
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

        HTMLGenerator::row(5, 5, 5);
        HTMLGenerator::tag("h2", "Add a new " . StringUtils::removeUnderscore($this->toSingular($name)));
        HTMLGenerator::form("post", "motherboards", [
            ["label" => "Name", "type" => "text", "name" => "name", "value" => ""],
            ["label" => "Description", "type" => "text", "name" => "description", "value" => ""],
            ["label" => "price", "type" => "text", "name" => "price", "value" => ""],
            ["label" => "Specification name", "type" => "text", "name" => "spec_name", "value" => ""],
            ["label" => "", "type" => "submit", "name" => "submit", "value" => "Insert motherboard"]
        ]);
        HTMLGenerator::closeRow();
    }

    private function toSingular(string $category)
    {
        //Remove "s" from the end
        $category = substr($category, 0, strlen($category) - 1);

        //If the last two characters are "ie", convert them to "y"
        if (substr($category, strlen($category) - 2) === "ie") {
            $category = substr($category, 0, strlen($category) - 2) . "y";
        }

        return $category;
    }
}