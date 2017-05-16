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

    public function get()
    {

        if (isset($_GET['path']) && $_GET['path'] !== "computer_parts") {
            $category = $this->toCamelCase($_GET['path']);
            $this->{$category}();

        } else {
            foreach ($this->categories as $category) {

                $titleFromLink = str_replace("_", " ", $category);
                HTMLGenerator::tag("h3", ucfirst($titleFromLink));
                HTMLGenerator::link($category, "Check all " . $titleFromLink);
            }
        }

        //TODO -- get content from database
        //Find a way to create main category -> sub category relationship in database
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


    private function motherboards()
    {
        echo "<div class=\"row small-up-2 medium-up-5 large-up-3\" style='margin-top:10px;'>";
        foreach (ProductModel::loadByCategoryId(2) as $motherboard) {
            echo "<div class=\"column\" style='border: 1px solid black; padding: 10px; height: 400px;'>";
            HTMLGenerator::image("//placehold.it/150x150", "placeholder 150x150",
                "float-center", "margin-bottom:30px");
            HTMLGenerator::link("motherboards/" . $motherboard->id, $motherboard->name,
                "float-center text-center", "margin-bottom:30px");

            echo " <ul>";
            foreach ($motherboard->getProductSpecModel() as $productSpecModel) {
                echo "<li>" . $productSpecModel->name . "</li>";
            }
            echo "</ul>";

            HTMLGenerator::tag("h3", "$" . $motherboard->price);
            echo "</div>";
        }

        echo "</div>";

        HTMLGenerator::row(5, 5, 5);
        HTMLGenerator::tag("h2", "Add a new motherboard");
        HTMLGenerator::form("post", "motherboards", [
            ["label" => "Name", "type" => "text", "name" => "name", "value" => ""],
            ["label" => "Description", "type" => "text", "name" => "description", "value" => ""],
            ["label" => "price", "type" => "text", "name" => "price", "value" => ""],
            ["label" => "Specification name", "type" => "text", "name" => "spec_name", "value" => ""],
            ["label" => "", "type" => "submit", "name" => "submit", "value" => "Insert motherboard"]
        ]);
        HTMLGenerator::closeRow();
    }

    private function videoCards()
    {
        echo "In video cards";
    }

    private function processors()
    {
        echo "In processors";
    }

    private function ssds()
    {
        echo "In ssds";
    }

    private function hdds()
    {
        echo "In hdds";
    }

    private function powerSupplies()
    {
        echo "In power supplies";
    }

    private function chassis()
    {
        echo "In chassis";
    }

    private function toCamelCase(string $category)
    {
        $category = ucwords($category, "_");

        //Remove "_" from the inside of the category
        $category = str_replace("_", "", $category);
        $category = lcfirst($category);

        return $category;

    }
}