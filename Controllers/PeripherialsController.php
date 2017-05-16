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

class PeripherialsController implements Controller
{

    private $categories = ["monitors", "mice", "keyboards", "external_hdds"];

    public function get()
    {
        if (isset($_GET['path']) && $_GET['path'] !== "peripherials") {
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
}