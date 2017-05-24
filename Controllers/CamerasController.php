<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 24.05.2017
 * Time: 20:14
 */

namespace Controllers;


use Utils\HTMLGenerator;
use Utils\StringUtils;

class CamerasController implements Controller
{

    private $categories = ["d_slr", "compact", "bridge"];

    public function get()
    {
        if (isset($_GET['path']) && $_GET['path'] !== "speakers") {
            $this->{$_GET['path']}($_GET['path']);
        } else {
            foreach ($this->categories as $category) {
                $titleFromLink = StringUtils::removeUnderscore($category);
                HTMLGenerator::tag("h3", ucfirst($titleFromLink));
                echo HTMLGenerator::link($category, "Check all " . $titleFromLink);
            }
        }
    }

    public function post()
    {
        // TODO: Implement post() method.
    }
}