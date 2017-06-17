<?php
/**
 * Created by PhpStorm.
 * User: L13
 * Date: 08/05/2017
 * Time: 08:40
 */

namespace Controllers;


use Models\ProductModel;
use Models\ProductResourcesModel;
use Models\ProductSpecDescriptionModel;
use Models\ProductSpecModel;
use Utils\HTMLGenerator;
use Utils\StringUtils;

class ComputerPartsController extends BaseController implements Controller
{
    private $categories = ["motherboards", "video_cards", "processors", "ssds", "hdds", "power_supplies", "chassis"];
    const MOTHERBOARDS_CATEGORY_ID = 2;
    const VIDEO_CARDS_CATEGORY_ID = 3;
    const PROCESSORS_CATEGORY_ID = 4;
    const SSDS_CATEGORY_ID = 5;
    const HDDS_CATEGORY_ID = 6;
    const POWER_SUPPLIES_CATEGORY_ID = 7;
    const CHASSIS_CATEGORY_ID = 8;
    const MAIN_CATEGORY_PATH = "computer_parts";

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