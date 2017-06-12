<?php

namespace Controllers;

use Models\CategoriesModel;
use Utils\HTMLGenerator;


/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 12.04.2017
 * Time: 16:30
 */
class IndexController extends BaseController implements Controller
{
    private $mainCategoryIds = [1, 9, 14, 18, 22, 27, 28, 30];

    public function post()
    {
        if (isset($_POST['login'])) {
            echo "it is login";
        }
    }

    public function get()
    {
        echo HtmlGenerator::tag("h2", "Good products");
        $this->showRandomProduct();
    }

    public function showRandomProduct()
    {
        $categoryId = rand(2, 34);

        if (!in_array($categoryId, $this->mainCategoryIds)) {

            $categoryName = CategoriesModel::loadById($categoryId)->name;
            echo "<div class=\"row small-up-2 medium-up-5 large-up-3\" style='margin-top:10px;'>";

            $this->displayProducts($categoryId, $categoryName);
            echo "</div>";
        }
    }
}