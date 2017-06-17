<?php
/**
 * Created by PhpStorm.
 * User: L13
 * Date: 22/05/2017
 * Time: 11:08
 */

namespace Controllers;

use Utils\HTMLGenerator;
use Utils\StringUtils;

class TelephonesController extends BaseController implements Controller
{

    private $categories = ["smartphones", "smartwatches", "external_batteries", "selfie_sticks", "memory_cards", "chargers", "wireless_chargers"];
    const SMARTPHONES_CATEGORY_ID = 19;
    const SMARTWATCHES_CATEGORY_ID = 20;
    const EXTERNAL_BATTERIES_CATEGORY_ID = 21;
    const MAIN_CATEGORY_PATH = "telephones";

    public function get()
    {
        $this->displayAllProductsByCategory(self::MAIN_CATEGORY_PATH, $this->categories);
    }


    public function post()
    {
        if (isset($_POST['submit'])) {
            $categoryId = constant("self::" . strtoupper($_GET['path']) . "_CATEGORY_ID");
            $this->insertNewProduct($categoryId);
        }

        if (isset($_POST['delete_product'])) {
            $productId = StringUtils::sanitizeString($_POST['product_id']);
            $this->deleteProduct($productId);
        }
    }

    public function __call($name, $arguments)
    {
        $categoryId = constant("self::" . strtoupper($arguments[0]) . "_CATEGORY_ID");

        echo "<div class=\"row small-up-2 medium-up-5 large-up-3\" style='margin-top:10px;'>";

        $this->displayProducts($categoryId, $name);

        $this->insertNewProductForm($name);
        HTMLGenerator::closeRow();
    }
}