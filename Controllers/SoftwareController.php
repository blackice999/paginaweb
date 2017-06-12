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

class SoftwareController extends BaseController implements Controller
{
    private $categories = ["operating_systems", "office_apps", "security_solutions"];
    const OPERATING_SYSTEMS_CATEGORY_ID = 15;
    const OFFICE_APPS_CATEGORY_ID = 16;
    const SECURITY_SOLUTIONS_CATEGORY_ID = 17;
    const MAIN_CATEGORY_PATH = "software";

    public function get()
    {
        $this->displayAllProductsByCategory(self::MAIN_CATEGORY_PATH, $this->categories);
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
            echo HTMLGenerator::tag("p", "Inserted new " .
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

        $this->insertNewProduct($name);
        HTMLGenerator::closeRow();
    }
}