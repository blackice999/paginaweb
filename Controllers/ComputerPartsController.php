<?php
/**
 * Created by PhpStorm.
 * User: L13
 * Date: 08/05/2017
 * Time: 08:40
 */

namespace Controllers;


class ComputerPartsController implements Controller
{
    private $categories = ["motherboards", "video_cards", "processors", "ssds", "hdds", "power_supplies", "chassis"];

    public function get()
    {

        foreach ($this->categories as $category) {

            echo "<h3>" . ucfirst(str_replace("_", " ", $category)) . "</h3> <a href='computer_parts?category='" . $category . "> Check all " . str_replace("_", " ", $category) . "</a>";
        }

        if (isset($_GET['category'])) {


            $category = $_GET['category'];
            $this->{$category}();

        }
    }

    public function post()
    {

    }

    public function video()
    {
        echo "yes";
    }
}