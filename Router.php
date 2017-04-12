<?php

/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 09.04.2017
 * Time: 19:15
 */
class Router
{
    private $path;
    private $class = "Controllers\\";
    private $classPath = "";

    private $categories = [
        "computer_parts" => ["motherboards", "video_cards", "processors", "ssds", "hdds", "power_supplies", "chassis"],
        "peripherials" => ["monitors", "mice", "keyboards", "external_hdds"],
        "software" => ["operating_system", "office_apps", "security_solutions"],
        "telephones" => ["smartphones", "smartwatches", "external_batteries", "gsm_accessories"],
        "audio_photo" => ["speakers", "microphones", "cameras"],
        "informations" => [],
        "contact" => [],
        "account" => [],
        "register" => []
    ];

    public function processRequest(string $path)
    {
        if ($this->isMainCategory($path)) {
            $this->generateClassFromPath($path);
        } else {

            //Will return, for example, "computer_parts" if the subcategory is "monitors"
            $this->generateClassFromPath($this->getMainCategoryFromSubcategory($path));
        }

        return new $this->class;
    }

    /**
     * Will return, for example, "computer_parts" if the subcategory is "monitors"
     * @param string $path the subcategory path that was sent to the class
     * @return string The path of the main category or an empty string if the $path is already a main category
     *
     */
    private function getMainCategoryFromSubcategory(string $path) : string
    {
        foreach ($this->categories as $categoryName => $subCategory) {
            if (in_array($path, $subCategory)) {
                return $categoryName;
            }
        }

        return "";
    }

    /**
     * @param string $path The given path to check
     * @return bool If it is a main category
     */
    private function isMainCategory(string $path) : bool
    {
        return empty($this->getMainCategoryFromSubcategory($path));
    }

    /**
     * Convert a path into a class name
     * where every first letter is uppercased and are joined together
     * and "Controller" is appended to end
     * for example, "computer_parts" will be "ComputerPartsController"
     * @param string $path Path to convert into a class name
     */
    private function generateClassFromPath(string $path)
    {
        $this->path = $path;

        //Uppercase every word, and word that are after "_"
        $this->path = ucwords($this->path, "_");

        //Remove "_" from the string and replace with nothing
        $this->path = str_replace("_", "", $this->path);

        //Split the path by "/"
        $words = explode("/", $this->path);

        foreach ($words as $word) {
            $this->class .= $word;
        }

        $this->class .= "Controller";

        $this->classPath = "Controllers/" . $this->class . ".php";
    }
}