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

        if (isset($_GET['category'])) {
            $category = $this->toCamelCase($_GET['category']);
            $this->{$category}();

        } else {
            foreach ($this->categories as $category) {

                $titleFromLink = str_replace("_", " ", $category);
                HTMLGenerator::tag("h3", ucfirst($titleFromLink));
                HTMLGenerator::link("computer_parts?category=" . $category, "Check all " . $titleFromLink);
            }
        }
    }

    public function post()
    {

    }


    public function __call($name, $arguments)
    {
        echo "in " . $name;
    }
//    private function motherboards()
//    {
//        echo "in motherboards";
//    }


    private function processors()
    {
        echo "In processors";
    }

    private function ssds()
    {
        echo "In ssds";
    }

    private function hdds()
    {
        echo "In hdds";
    }

    private function powerSupplies()
    {
        echo "In power supplies";
    }

    private function chassis()
    {
        echo "In chassis";
    }

    private function toCamelCase(string $category)
    {
        $category = ucwords($category, "_");

        //Remove "_" from the inside of the category
        $category = str_replace("_", "", $category);
        $category = lcfirst($category);

        return $category;

    }
}