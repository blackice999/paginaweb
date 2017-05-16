<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 13.04.2017
 * Time: 17:31
 */

namespace Controllers;


use Utils\HTMLGenerator;
use Utils\StringUtils;

class SoftwareController implements Controller
{
    private $categories = ["operating_systems", "office_apps", "security_solutions"];

    public function get()
    {
        if (isset($_GET['path']) && $_GET['path'] !== "software") {
            $this->{$_GET['path']}($_GET['path']);
        } else {
            foreach ($this->categories as $category) {
                $titleFromLink = StringUtils::removeUnderscore($category);
                HTMLGenerator::tag("h3", ucfirst($titleFromLink));
                HTMLGenerator::link($category, "Check all " . $titleFromLink);
            }
        }
    }

    public function post()
    {
        // TODO: Implement post() method.
    }

    public function __call($name, $arguments)
    {
        echo $name;
    }
}