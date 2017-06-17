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
    const MAIN_CATEGORY_PATH = "gsm_accessories";

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