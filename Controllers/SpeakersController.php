<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 24.05.2017
 * Time: 20:03
 */

namespace Controllers;


use Models\ProductModel;
use Models\ProductSpecModel;
use Utils\HTMLGenerator;
use Utils\StringUtils;

class SpeakersController extends BaseController implements Controller
{

    private $categories = ["portable_speakers"];
    const PORTABLE_SPEAKERS_CATEGORY_ID = 31;
    const MAIN_CATEGORY_PATH = "speakers";

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