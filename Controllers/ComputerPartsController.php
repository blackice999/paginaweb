<?php
/**
 * Created by PhpStorm.
 * User: L13
 * Date: 08/05/2017
 * Time: 08:40
 */

namespace Controllers;


use Utils\HTMLGenerator;

class ComputerPartsController implements Controller
{
    private $categories = ["motherboards", "video_cards", "processors", "ssds", "hdds", "power_supplies", "chassis"];

    public function get()
    {

        foreach ($this->categories as $category) {

            $titleFromLink = str_replace("_", " ", $category);
            HTMLGenerator::tag("h3", ucfirst($titleFromLink));
            HTMLGenerator::link("computer_parts?category=" . $category, "Check all " . $titleFromLink);
        }


        if (isset($_GET['category'])) {
            echo "ys";
            $category = $_GET['category'];
            $this->{$category}();

        }
    }

    public function post()
    {

    }

    public function video_cards()
    {
        echo "yes";
    }
}