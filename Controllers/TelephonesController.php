<?php
/**
 * Created by PhpStorm.
 * User: L13
 * Date: 22/05/2017
 * Time: 11:08
 */

namespace Controllers;


use Models\ProductModel;
use Models\ProductSpecModel;
use Utils\HTMLGenerator;
use Utils\StringUtils;

class TelephonesController implements Controller
{

    private $categories = ["smartphones", "smartwatches", "external_batteries", "selfie_sticks", "memory_cards", "chargers", "wireless_chargers"];
    private $gsmAccessoriesCategories = ["selfie_sticks", "memory_cards", "chargers", "wireless_chargers"];
    const SMARTPHONES_CATEGORY_ID = 19;
    const SMARTWATCHES_CATEGORY_ID = 20;
    const EXTERNAL_BATTERIES_CATEGORY_ID = 21;

    public function get()
    {
        if (isset($_GET['path']) && $_GET['path'] !== "telephones") {
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
//        if ($name !== "gsm_accessories") {
//            $this->{$name}($name);
//        } else {
//            foreach ($this->gsmAccessoriesCategories as $category) {
//                $titleFromLink = StringUtils::removeUnderscore($category);
//                HTMLGenerator::tag("h3", ucfirst($titleFromLink));
//                echo HTMLGenerator::link($category, "Check all " . $titleFromLink);
//            }
//        }


//        echo $name;
    }
}