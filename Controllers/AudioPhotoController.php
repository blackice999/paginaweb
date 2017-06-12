<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 13.04.2017
 * Time: 17:32
 */

namespace Controllers;


use Models\ProductModel;
use Models\ProductSpecDescriptionModel;
use Models\ProductSpecModel;
use Utils\HTMLGenerator;
use Utils\StringUtils;

class AudioPhotoController extends BaseController implements Controller
{

    private $categories = ["speakers", "portable_speakers", "microphones", "cameras", "d_slrs", "compacts", "bridges"];
    const SPEAKERS_CATEGORY_ID = 28;
    const MICROPHONES_CATEGORY_ID = 29;
    const CAMERAS_CATEGORY_ID = 30;
    const MAIN_CATEGORY_PATH = "audio_photo";

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