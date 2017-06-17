<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 13.04.2017
 * Time: 17:31
 */

namespace Controllers;


use Models\ProductModel;
use Models\ProductSpecDescriptionModel;
use Models\ProductSpecModel;
use Utils\HTMLGenerator;
use Utils\StringUtils;

class PeripherialsController extends BaseController implements Controller
{
    private $categories = ["monitors", "mice", "keyboards", "external_hdds"];
    const MONITORS_CATEGORY_ID = 10;
    const MICE_CATEGORY_ID = 11;
    const KEYBOARDS_CATEGORY_ID = 12;
    const EXTERNAL_HDDS_CATEGORY_ID = 13;
    const MAIN_CATEGORY_PATH = "peripherials";

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