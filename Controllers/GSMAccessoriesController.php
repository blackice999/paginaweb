<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 24.05.2017
 * Time: 19:38
 */

namespace Controllers;


use Models\ProductModel;
use Models\ProductSpecModel;
use Utils\HTMLGenerator;
use Utils\StringUtils;

class GSMAccessoriesController extends BaseController implements Controller
{

    private $categories = ["selfie_sticks", "memory_cards", "chargers", "wireless_chargers"];
    const SELFIE_STICKS_CATEGORY_ID = 23;
    const MEMORY_CARDS_CATEGORY_ID = 24;
    const CHARGERS_CATEGORY_ID = 25;
    const WIRELESS_CHARGERS_CATEGORY_ID = 26;

    public function get()
    {
        if (isset($_GET['path']) && $_GET['path'] !== "gsm_accessories") {
            $this->{$_GET['path']}($_GET['path']);
        } else {
            foreach ($this->categories as $category) {
                $titleFromLink = StringUtils::removeUnderscore($category);
                HTMLGenerator::tag("h3", ucfirst($titleFromLink));
                echo HTMLGenerator::link($category, "Check all " . $titleFromLink);
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
            HTMLGenerator::tag("p", "Inserted new " .
                StringUtils::removeUnderscore(StringUtils::toSingular($_GET['path'])) .
                " with the id " . $result->id);
            ProductSpecModel::create($result->id, $specName);
        }
    }

    public function __call($name, $arguments)
    {
        $categoryId = constant("self::" . strtoupper($arguments[0]) . "_CATEGORY_ID");

        echo "<div class=\"row small-up-2 medium-up-5 large-up-3\" style='margin-top:10px;'>";

        $this->displayProducts($categoryId, $name);

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